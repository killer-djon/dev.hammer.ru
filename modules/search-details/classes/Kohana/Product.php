<?php defined('SYSPATH') OR die('No direct script access.');
/**
 *
 * @package Search
 */
 
class Kohana_Product extends Kohana_Search 
{
	const PRODUCT_URL = 'http://www.motoristam.ru/search_part.html?q_part={product}&full_part=no';
	
	const PARTS_URL = 'http://www.motoristam.ru/';
	
	
	private static $_instance = NULL;
	
	
	/*
	 * Our cross products data
	 *
	 * @var array	
	 */
	protected $_cross_products = [];
	
	
	
	public static function getInstance()
	{
		if( is_null( self::$_instance ) )
		{
			self::$_instance = new self();
		}
		
		return self::$_instance;
	}
	
	
	public function getCrossProductsData()
	{
		return $this->_cross_products;
	}
	
	
	/*
	 * Load all product by category Name (like Audi)
	 * and parts name (like ABB)
	 *
	 * @param String $categoryName - Name of the category selected ( like Audi )
	 * @param String $partsName - Name of the parts of category ( like ABB )
	 *
	 * @return Object Product - Return self instance
 	 */
	public function loadProducts($categoryName, $partsName)
	{
		$categoryModel = MongoModel::factory('Categories');
		$categoryModel->selectDB();

		$parts = $categoryModel
			->where('param', '=', 'parts')
			->where('auto', '=', $categoryName)
			->where('name', 'regex', "/^$partsName$/is")
			->find();
			
		if( $parts->loaded() )
		{
			$this->setCurrent($parts->lastDocument());
			// then search products by this parts
			$this->createSearchIndex('products', 'name', 'parts', $partsName);
			
			$productModel =  MongoModel::factory('Products');
			$productModel->selectDB();
			
			$rowProducts = $productModel
				->where('category', '=', $categoryName)
				->where('parentName', '=', $parts->get('name'))
				->sort('groupName')
				->find_all();
				
			if( !empty($rowProducts) && count($rowProducts) > 0 )
			{
				foreach( $rowProducts as $key => $item )
				{
					$this->offsetSet($key, $item);
				}
				
				$this->refreshData('link');
				$this->_cross_products = $this->collectCrossProducts('article');
			}
		}
		
		return $this;
	}
	
	
	
	/*
	 * Save pull products array to base
	 * and arange them after to multidimensional array
	 * and offsetSet data
	 *
	 * @param String $categoryName - Category name from uri string
	 * @param String $partsName - Name of the parts of this porducts array
	 *
	 * @return void	
	 */
	public function getProducts($categoryName, $partsName)
	{
		//$this->createSearchIndex('categories', 'name', $param, $name);
		
		$categoryModel = MongoModel::factory('Categories');
		$categoryModel->selectDB();
		
		$parts = $categoryModel
			->where('param', '=', 'parts')
			->where('auto', '=', $categoryName)
			->where('name', 'regex', "/^$partsName$/is")
			->find();
			
		if( $parts->loaded() )
		{
			$this->setCurrent($parts->lastDocument());
			$this->createSearchIndex('products', 'name', 'parts', $partsName);
			$url = rtrim(self::PARTS_URL, '/') .'/'. ltrim($parts->get('link'), '/');
			$page = $this->searchPage($url);
			
			if( !empty( $page ) )
			{
				$htmlNodes = Domparser::getInstance($page);
				
				$htmlNodes->parseDocument("#result-by-size");
				$htmlNodes->parseContainer("div");
				$htmlNodes->parseProducts('div');
				$htmlNodes->createProducts($categoryName, $parts);	
				
				if( $this->offsetSize() > 0 )
				{
					
					$offsets = $this->getOffsets();
					$this->clearOffsets();
					
					foreach($offsets as $key => $item)
					{
						$modelView = MongoModel::factory('Products');
						$modelView->selectDB();	
						
						$row = $modelView
							->where('article', '=', $item['article'])
							->where('category', '=', $item['category'])
							->where('parentName', '=', $item['parentName'])
							->sort('groupName')
							->find();
							
						if( !$row->loaded() )
						{
							$item['date_create'] = new MongoDate();
							$modelView->values($item);
							$modelView->save();			
							
							$this->offsetSet($key, $modelView->lastDocument());
						}else
						{
							$modelView->set('parentId', $parts->get('_id')->{'$id'});
							$modelView->set('parentName', $parts->get('name'));
							//$modelView->set('category', $categoryName);
							
							$modelView->save();	
							
							$this->offsetSet($key, $row->lastDocument());
						}
					}
					
					$this->refreshData('link');
					$this->_cross_products = $this->collectCrossProducts('article');
				}
			}
		}
		
		return $this;
	}
	
	
	/*
	 * Get single product by self article
	 * this need to show all crosses of this product
	 *
	 * @param String $article - Article string name
	 *
	 * @return Array $product - Return Array of the finded product
 	 */
	public function getProductByArticle( $article = NULL )
	{
		$product = array();
		
		if( !is_null( $article ) )
		{
			$model = MongoModel::factory('Products');
			$model->selectDB();	
			
			$row = $model
				->where('article', '=', $article)
				->sort('article')
				->find();
			
			if( $row->loaded() )	
			{
				$this->createSearchIndex('products', 'article', 'products', $article, 'products/'.$article);
				$product = $row->getSingleDocument();
			}
			
		}
		
		return $product;
	}
	
	
	/*
	 * Find data into DB by search article
	 * after if not find then search remote
	 *
	 * @param String $article - Article string name
	 *
	 * @return Object Product - Return self instance
 	 */
	public function findData($name)
	{
		$this->createSearchIndex('products', 'article', 'search', $name, 'products/?search='.$name);

		$model = MongoModel::factory('Products');
		$model->selectDB();	
		
		$rows = $model
			->where('search_article', '=', $name)
			->sort('article')
			->find_all();
		
		if( !empty($rows) )
		{
			$this->clearOffsets();
			foreach( $rows as $key => $item )
			{
				$this->offsetSet($key, $item);
			}	
			
			$this->refreshData('article');
			$this->_cross_products = $this->collectCrossProducts('article');
		}
		
		return $this;
	}
	
	
	
	/*
	 * Load Crosses products by article
	 * from db before search them to remote page
	 *
	 * @param Array $product - Current array of the product, need the article
	 *
	 * @return Object Product - Return self instance
 	 */
	public function loadCrosses( $product, $searchURL = '' )
	{
		$model = MongoModel::factory('Crosses');
		$model->selectDB();
		
		$rows = $model 
			->where('cross_article', '=', $product['article'])
			->sort('article')
			->find_all();
		
		$this->setCurrent($product);
		if( !empty( $rows ) )
		{
			$this->createSearchIndex('crosses', 'cross_article', 'crosses', $searchURL);
			
			$this->clearOffsets();
			foreach( $rows as $key => $item )
			{
				$this->offsetSet($key, $item);
			}
			
			$this->refreshData('link');
		}
		
		return $this;
	}
	
	
	/*
	 * Search remote crosses products
	 * by current article, but article must be set
	 *
	 * @param Array $product - Current array of the product, need the article
	 *
	 * @return Object Product - Return self instance
 	 */
	public function searchCrosses( $product, $searchURL = '' )
	{
		$clearURL = preg_replace('/\?([a-z_\-0-9.\/=&]+)$/i', '', $product['link']);
		$clearURL = trim($clearURL, '/');
		
		$url = self::PARTS_URL . $clearURL;
		$page = $this->searchPage($url);
		
		$this->setCurrent($product);
		if ( !empty( $page ) )
		{
			$htmlNodes = Domparser::getInstance($page);
			
			$htmlNodes->parseDocument("#main-box");
			$htmlNodes->parseContainer("table[cellpadding=7] ~ table:last");
			$htmlNodes->parseDetails( $htmlNodes->getContainer() );
			$htmlNodes->createProducts();
			
			if( $this->offsetSize() > 0 ){
				
				$this->createSearchIndex('crosses', 'cross_article', 'crosses', 
					$product['article'], 
					$searchURL);
				
				$this->refreshData('link');
				$offsets = $this->getOffsets();
				
				$this->clearOffsets();
				
				foreach( $offsets as $key => $item )
				{
					$model = MongoModel::factory('Crosses');
					$model->selectDB();	
					
					$row = $model
						->where('name', '=', $item['name'])
						->where('article', '=', $item['article'])
						->where('cross_article', '=', $product['article'])
						->sort('article')
						->find();
						
					if( !$row->loaded() )
					{
						$item['date_create'] = new MongoDate();
						$item['cross_article']	= $product['article'];
						$item['parentId'] = $product['_id']['$id'];
						
						$model->values($item);
						$model->save();			
						
						$this->offsetSet($key, $model->lastDocument());
					}else
					{
						$model->set('cross_article', $product['article']);
						$model->set('date_create', new MongoDate());
						
						$model->save();	
						
						$this->offsetSet($key, $row->lastDocument());
					}
				}
				
				$this->refreshData('link');
			}
		}
		
		return $this;		
	}
	
	public function searchData($name)
	{
		$article = preg_replace('/([^\w]+)/', '', $name);
		
		$url = preg_replace('/{product}/', urlencode($article), self::PRODUCT_URL);
		
		$page = $this->searchPage($url);
		
		if ( !empty( $page ) )
		{
			$this->createSearchIndex('products', 'article', 'search', $name, 'products/?search='.$name);
			
			$htmlNodes = Domparser::getInstance($page);
			
			$htmlNodes->parseDocument("#result-by-size");
			$htmlNodes->parseContainer("div");
			$htmlNodes->parseProducts();
			$htmlNodes->createProducts();
			
			if( $this->offsetSize() > 0 )
			{
				$offsets = $this->getOffsets();
				
				$this->clearOffsets();
				foreach( $offsets as $key => $item )
				{
					$model = MongoModel::factory('Products');
					$model->selectDB();	
					
					$row = $model
						->where('name', '=', $item['name'])
						->where('article', '=', $item['article'])
						->sort('article')
						->find();
						
						
					if( !$row->loaded() )
					{
						$item['date_create'] = new MongoDate();
						$item['search_article']	= $name;
						$model->values($item);
						$model->save();			
						
						//$__data[ $item['link'] ] = $model->lastDocument();
						$this->offsetSet($key, $model->lastDocument());
					}else
					{
						$model->set('search_article', $name);
						$model->set('date_create', new MongoDate());
						$model->save();	
						
						//$__data[ $item['link'] ] = $row->lastDocument();
						$this->offsetSet($key, $row->lastDocument());
					}
				}
				
				$this->refreshData('link');
				$this->_cross_products = $this->collectCrossProducts('article');
			}
			
		}
	}
}