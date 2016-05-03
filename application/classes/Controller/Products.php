<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Products extends Controller_Main 
{

	public $template = 'templates/second/main';
	
	
	public function after()
    {
        $this->template->header = View::factory('templates/second/header');
        $this->template->footer = View::factory('templates/second/footer');

        parent::after();

    }

	public function action_index()
	{
		$this->setScript('assets/js/second.js', 'footer');
		
		
		
		$this->setStyle('assets/css/sidebar.css', 'all');
		
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
	
		$this->template->title = "";
		$this->template->content = View::factory('templates/second/search_content');
		$this->template->content->title = 'Поиск по номеру детали: '.$name;
		$this->template->content->breadcrumbs = View::factory('templates/breadcrumbs');

		Breadcrumbs::set([
            URL::base() => 'Главная',
            '/categories' => 'Производители',
        ]);
        
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
			
			//$this->template->title = 'Детали двигателя';
			$this->template->content->category_view = View::factory('search/product');
			
			$this->template->content->category_view->current = $product->getCurrent();
			$this->template->content->category_view->parts = $offsets;
			$this->template->content->category_view->cross_products = $product->getCrossProductsData();
		}else
		{
			//$this->template->title = 'Детали двигателя';
			$this->template->content->category_view = View::factory('search/product');
			
			$this->template->content->category_view->current = $product->getCurrent();
			$this->template->content->category_view->empty_parts = 'По вашему запросу ничего не найдено, попробуйте ввести еще раз';
			
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
			
			$this->template->title = "";
			$this->template->content = View::factory('templates/second/parts_content');
			
			$this->template->content->title = 'Возможные замены детали: '.$article;
			$this->template->content->breadcrumbs = View::factory('templates/breadcrumbs');
			$this->template->content->category_view = View::factory('products/product');
				
			Breadcrumbs::set([
	            URL::base() => 'Главная',
	            '/categories' => 'Производители',
	            "/categories/{$productRow['category']}/{$productRow['parentName']}"	=> $productRow['parentName'],
	            "/products/?type=products&article={$productArticle}"	=> $productArticle,
	            "?type=crosses&product={$productArticle}&article={$article}"	=> $article
	        ]);	
				
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
				
				//$this->template->title = 'Список возможных замен для детали: '.$article;
				//$this->template->content = View::factory('products/product');
				
				$this->template->content->category_view->title = 'Список возможных замен для детали: '.$article;
				$this->template->content->category_view->current = $product->getCurrent();
				$this->template->content->category_view->parts = $offsets;
			}else
			{
				//$this->template->title = 'Список возможных замен для детали: '.$article;
				//$this->template->content = View::factory('products/product');
				
				$this->template->content->category_view->title = 'Список возможных замен для детали: '.$article;
				$this->template->content->category_view->current = $product->getCurrent();
				$this->template->content->category_view->empty_parts = 'По вашему запросу ничего не найдено, попробуйте ввести еще раз';
				
			}
		}else
		{
			$this->template->content->category_view->empty_parts = 'По вашему запросу ничего не найдено, попробуйте ввести еще раз';
		}	
		
	}
	
	
	public function render_product( $article = NULL )
	{
		
		$product = Product::getInstance();
		$row = $product->getProductByArticle($article);
	
		$this->template->title = "";
		$this->template->content = View::factory('templates/second/parts_content');
		
		$this->template->content->title = 'Возможные замены детали: '.$article;
		$this->template->content->breadcrumbs = View::factory('templates/breadcrumbs');
		$this->template->content->category_view = View::factory('products/product');		
        
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
			
			$current = $product->getCurrent();
			
			Breadcrumbs::set([
	            URL::base() => 'Главная',
	            '/categories' => 'Производители',
	            //"/categories/{$current['category']}/{$current['parentName']}"	=> $current['parentName'],
	            '/categories/view/'.$current['category']	=> $current['category'],
	            "/products/?type=products&article={$article}"	=> $article
	        ]);
	        
			$this->template->content->category_view->current = $current;
			
			if( $product->offsetSize() > 0 )
			{
				$productsArr = $product->getOffsets();
				
				$offsets = Arr::build_tree($productsArr, 'groupName');
				
				$this->template->content->category_view->parts = $offsets;
			}else
			{
				
				$this->template->content->category_view->empty_parts = 'По вашему запросу ничего не найдено, попробуйте ввести еще раз';
				
			}
			
			$this->template->content->category_view->cross_products = $product->getCrossProductsData();
			$this->template->content->category_view->title = 'Список возможных замен для детали: '.$article;
			
		}else
		{
			$this->template->content->category_view->empty_parts = 'По вашему запросу ничего не найдено, попробуйте ввести еще раз';	
		}
		
	}

} // End Welcome
