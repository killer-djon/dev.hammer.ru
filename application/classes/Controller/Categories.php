<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Categories extends Controller_Main 
{

	public $template = 'templates/second/main';

	protected $_types = array(
		0	=> 'view',
		1	=> 'generic',
		2	=> 'engine',
		3	=> 'parts'
	);
	
	
	protected $_models = array(
		'view'	=> 'Производитель',
		'generic'	=> 'Модель',
		'engine'	=> 'Модификация',
		'parts'		=> 'Двигатель'	
	);

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
		
        $path = $this->request->param('path');
		
		if( !empty($path) )
		{
			// в этом случае у нас есть адресная строка для работы с категориями
			// адресная строка формируется по типу view/Audi
			
			$category = explode("/", $path); // uri path
			
			if( count($category) >= 2 )
			{
				// в случае если адресная строка корректная
				// это страница перехода по категориями
				
				if( !in_array($category[0], $this->_types) )
				{
					// значит мы идем по пути вывода деталей для движка
					$this->renderParts($category[0], $category[1]);
				}else
				{
					// а тут мы просто идем по цепи категорий
					$key = array_search($category[0], $this->_types);
					$this->render_category($this->_types[$key+1], $category[1]);
				}
			}else
			{
				if( count($category) === 1 )
				{
					if( !in_array($category[0], $this->_types) )
					{
						echo "get parts";
					}else
					{
						HTTP::redirect(URL::base(true).'categories');
					}
				}
			}
		}else
		{
			$search_category = $this->request->query('search'); // происходит поиск, значит есть аргументы поисковой строки
			
			if( !empty( $search_category ) )
			{
				$this->searchCategory($search_category); // search parts by name	
			}else
			{
				// это страница всего каталога производителей
				$this->render_category();
			}
		}
	}
	
	
	public function renderParts($categoryName, $partsName)
	{
		$product = Product::getInstance();
		
		//$view = View::factory('categories/parts');
		
		$model = MongoModel::factory('SearchIndex');
		$model->selectDB();
		
		$searchRow = $model
			->where('collection', '=', 'products')
			->where('field', '=', 'name')
			->where('value', '=', $partsName)
			->where('search_page', '=', 'categories/'.$categoryName.'/'.$partsName)
			->find();
			
		if( $searchRow->loaded() )
		{
			$product->loadProducts($categoryName, $partsName);
		}else
		{
			$product->getProducts($categoryName, $partsName);
		}

        $current = $product->getCurrent();
        
		$this->template->title = "";
        $this->template->content = View::factory('templates/second/parts_content');
        $this->template->content->category_view = View::factory('categories/parts');
        $this->template->content->breadcrumbs = View::factory('templates/breadcrumbs');

        Breadcrumbs::set([
            URL::base() => 'Главная',
            '/categories' => 'Производители',
            "/categories/view/{$current['auto']}" => $current['auto'],
            //"/categories/generic/{$current['auto']}/{$current['parentName']}" => $current['parentName'],
            "/categories/{$current['auto']}/{$current['name']}" => $current['name'],
        ]);

        $this->template->content->title = 'Детали двигателя: '.$current['name'];
		if( $product->offsetSize() > 0 )
		{
			$productsArr = $product->getOffsets();
			$offsets = Arr::build_tree($productsArr, 'groupName');

			//$this->template->title = 'Детали двигателя';


			//$this->template->content = View::factory('categories/parts');

            $this->template->content->category_view->current = $current;
            $this->template->content->category_view->parts = $offsets;
            $this->template->content->category_view->cross_products = $product->getCrossProductsData();
		}else
		{
            $this->template->content->category_view->title = 'Детали двигателя';
			//$this->template->content = View::factory('categories/parts');

            $this->template->content->category_view->current = $current;
            $this->template->content->category_view->parts = 'По вашему запросу ничего не найдено, попробуйте ввести еще раз';
		}
	}

	public function action_singleCategory()
	{
		// Request::detect_uri() - Полученная ссылка на каталог
		$category = Category::getInstance();
		$category->getSingleCategory( Request::detect_uri() );
	}


	public function searchCategory($name = NULL)
	{
		$category = Category::getInstance();

		$model = MongoModel::factory('SearchIndex');
		$model->selectDB();

		$searchRow = $model
			->where('collection', '=', 'categories')
			->where('field', '=', 'name')
			->where('value', '=', $name)
			->find();

		$this->template->title = "";
		$this->template->content = View::factory('templates/second/search_content');
		$this->template->content->title = 'Поиск по коду двигателя: '.$name;
		$this->template->content->breadcrumbs = View::factory('templates/breadcrumbs');

		Breadcrumbs::set([
            URL::base() => 'Главная',
            '/categories' => 'Производители',
        ]);
        
		if( $searchRow->loaded() )
		{
			$category->findData($name);

		}else
		{
			$category->searchData($name);
		}

		if( $category->offsetSize() > 0 )
		{

			//$this->template->title = 'Поиск по коду двигателя';
			$this->template->content->category_view = View::factory('search/category');
			$this->template->content->category_view->parts = $category->getOffsets();
		}else
		{
			//$this->template->title = 'Поиск по коду двигателя';
			$this->template->content->category_view = View::factory('search/category');
			$this->template->content->category_view->empty_categories = 'По вашему запросу ничего не найдено, попробуйте ввести еще раз';
			$this->template->content->category_view->parts = array();
		}

	}


	public function render_category($type = 'view', $name = NULL)
	{

		$category = Category::getInstance();
		$category->getCategories($type, $name); // get default view categories - first levent

		$this->template->title = "";
        $this->template->content = View::factory('templates/second/content');
        $this->template->content->title = 'Каталог производителей';
        $this->template->content->breadcrumbs = View::factory('templates/breadcrumbs');

        $current = $category->getCurrent();
		if( $type == 'view' )
		{
            Breadcrumbs::set([
	            URL::base() => 'Главная',
	            '/categories' => 'Производители',
            ]);
            $this->template->content->category_view = View::factory('categories/category_view');
            $this->template->content->category_view->title = 'Каталог производителей';
		}else if( $type == 'generic' )
		{
            Breadcrumbs::set([
                URL::base() => 'Главная',
                '/categories' => 'Производители',
                "/categories/view/{$current['name']}"  => $current['name'],
            ]);
            $this->template->content->title = 'Производитель '.$current['name'];
			$this->template->content->category_view = View::factory('categories/category_generic');
			$this->template->content->category_view->title = 'Производитель '.$current['name'];
		}else if( $type == 'engine' )
		{
            Breadcrumbs::set([
                URL::base() => 'Главная',
                '/categories' => 'Производители',
                "/categories/view/{$current['parentName']}"  => "{$current['parentName']}",
                "/categories/generic/{$current['parentName']}/{$current['name']}"   => $current['name']
            ]);

            $this->template->content->title = 'Модель '.$current['name'];
			$this->template->content->category_view = View::factory('categories/category_engine');
			$this->template->content->category_view->title = 'Модель '.$current['name'];
		}
		
        $this->template->content->category_view->current = $current;
        $this->template->content->category_view->categories = $category->getOffsets();
	}
	
	public function filter_categories($type = 'view', $name = NULL)
	{
		$this->response->body('filter categories');
	}

} // End Welcome
