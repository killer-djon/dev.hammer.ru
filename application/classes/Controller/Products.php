<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Products extends Controller_Main {

	public function action_index()
	{
		$path = $this->request->param('path', NULL);
		
		if( !empty( $path ) )
		{
			$product = explode('/', $path); // разбираем строку запроса
			
		}else
		{
			$search_product = $this->request->query('search'); // происходит поиск, значит есть аргументы поисковой строки
			
			if( !empty( $search_product ) )
			{
				$this->searchProduct($search_product); // search parts by name	
			}else
			{
				$type = $this->request->query('type');
				$article = $this->request->query('article');
				
				if( !empty( $type ) && !empty( $article ) )
				{
					$type = strtolower($type);
					
					if( $type == 'products' )
					{
						$this->render_product($article);
					}else
					{
						$productArticle = $this->request->query('product');
						$this->render_cross($productArticle, $article);
					}
				}else
				{
					$this->template->title = 'Детали двигателя';
					$this->template->content = View::factory('products/product');
					
					$this->template->content->current = array();
					$this->template->content->empty_parts = 'По вашему запросу ничего не найдено, попробуйте ввести еще раз';	
				}
			}
		}
	}
	
	
	public function searchProduct( $name )
	{
		$product = Product::getInstance();
		
		
		$model = MongoModel::factory('SearchIndex');
		$model->selectDB();
		
		$searchRow = $model
			->where('collection', '=', 'products')
			->where('field', '=', 'article')
			->where('value', '=', $name)
			->where('search_page', '=', 'products/?search='.$name)
			->find();
	
			
		if( $searchRow->loaded() )
		{
			$product->findData($name);
		}else
		{
			$product->searchData($name);
		}
		
		if( $product->offsetSize() > 0 )
		{
			$productsArr = $product->getOffsets();
			$offsets = Arr::build_tree($productsArr, 'groupName');
			
			$this->template->title = 'Детали двигателя';
			$this->template->content = View::factory('search/product');
			
			$this->template->content->current = $product->getCurrent();
			$this->template->content->parts = $offsets;
			$this->template->content->cross_products = $product->getCrossProductsData();
		}else
		{
			$this->template->title = 'Детали двигателя';
			$this->template->content = View::factory('search/product');
			
			$this->template->content->current = $product->getCurrent();
			$this->template->content->empty_parts = 'По вашему запросу ничего не найдено, попробуйте ввести еще раз';
			
		}
	}
	
	public function render_cross($productArticle, $article = NULL)
	{
		if( !is_null( $article ) )
		{
			$product = Product::getInstance();
			$productRow = $product->getProductByArticle($productArticle);
			
			$model = MongoModel::factory('SearchIndex');
			$model->selectDB();
			
			$modelCross = MongoModel::factory('Crosses');
			$modelCross->selectDB();
			
			$row = $modelCross
				->where('article', '=', $article)
				->where('cross_article', '=', $productArticle)
				->find();
					
			$searchRow = $model
				->where('collection', '=', 'crosses')
				->where('field', '=', 'cross_article')
				->where('value', '=', $article)
				->where('search_page', '=', 'products/?type=crosses&product='.$productArticle.'&article='.$article)
				->find();	
				
			if( !$searchRow->loaded() )
			{
				if( $row->loaded() )
				{
					$product->searchCrosses( 
						$row->getSingleDocument(), 
						'products/?type=crosses&product='.$productArticle.'&article='.$article 
					);
				}
			}else
			{
				$product->loadCrosses(
					$row->getSingleDocument(),
					'products/?type=crosses&product='.$productArticle.'&article='.$article 
				);
			}
			
			if( $product->offsetSize() > 0 )
			{
				$productsArr = $product->getOffsets();
				$offsets = Arr::build_tree($productsArr, 'groupName');
				
				$this->template->title = 'Список возможных замен для детали: '.$article;
				$this->template->content = View::factory('products/product');
				
				$this->template->content->title = 'Список возможных замен для детали: '.$article;
				$this->template->content->current = $product->getCurrent();
				$this->template->content->parts = $offsets;
			}else
			{
				$this->template->title = 'Список возможных замен для детали: '.$article;
				$this->template->content = View::factory('products/product');
				
				$this->template->content->title = 'Список возможных замен для детали: '.$article;
				$this->template->content->current = $product->getCurrent();
				$this->template->content->empty_parts = 'По вашему запросу ничего не найдено, попробуйте ввести еще раз';
				
			}
		}	
		
	}
	
	
	public function render_product( $article = NULL )
	{
		$product = Product::getInstance();
		$row = $product->getProductByArticle($article);
		
		if( !empty($row) )
		{
			$model = MongoModel::factory('SearchIndex');
			$model->selectDB();
			
			$searchRow = $model
				->where('collection', '=', 'crosses')
				->where('field', '=', 'cross_article')
				->where('value', '=', $article)
				->where('search_page', '=', 'products/?type=products&article='.$article)
				->find();
				
			if( !$searchRow->loaded() )	
			{
				$product->searchCrosses(
					$row, 
					'products/?type=products&article='.$article
				);
			}else
			{
				$product->loadCrosses(
					$row,
					'products/?type=products&article='.$article
				);
			}
			
			if( $product->offsetSize() > 0 )
			{
				$productsArr = $product->getOffsets();
				$offsets = Arr::build_tree($productsArr, 'groupName');
				
				$this->template->title = 'Список возможных замен для детали: '.$article;
				$this->template->content = View::factory('products/product');
				
				$this->template->content->title = 'Список возможных замен для детали: '.$article;
				$this->template->content->current = $product->getCurrent();
				$this->template->content->parts = $offsets;
			}else
			{
				$this->template->title = 'Список возможных замен для детали: '.$article;
				$this->template->content = View::factory('products/product');
				
				$this->template->content->title = 'Список возможных замен для детали: '.$article;
				$this->template->content->current = $product->getCurrent();
				$this->template->content->empty_parts = 'По вашему запросу ничего не найдено, попробуйте ввести еще раз';
				
			}
			
		}
	}

} // End Welcome
