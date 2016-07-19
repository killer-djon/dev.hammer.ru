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
		$this->setScript('assets/js/second.js', 'footer');
		$product = Product::getInstance($this->_cache);

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

		$this->template->title = "Детали двигателя {$current['name']} и возможные замены";
        $this->template->content = View::factory('templates/second/parts_content');
        $this->template->content->category_view = View::factory('categories/parts');
        $this->template->content->breadcrumbs = View::factory('templates/breadcrumbs');

		$meta_keywords = [
			"детали двигателя {$current['name']}",
			"производитель деталей {$current['auto']}",
		];

        Breadcrumbs::set([
            URL::base() => 'Главная',
            '/categories' => 'Каталог производителей',
            "/categories/view/{$current['auto']}" => $current['auto'],
            //"/categories/generic/{$current['auto']}/{$current['parentName']}" => $current['parentName'],
            "/categories/{$current['auto']}/{$current['name']}" => $current['name'],
        ]);


		$article_description = '';
        $this->template->content->title = 'Детали двигателя: '.$current['name'];
		if( $product->offsetSize() > 0 )
		{
			$productsArr = $product->getOffsets();
			$offsets = Arr::build_tree($productsArr, 'groupName');

			$article_keywords = array_combine(array_column($productsArr, 'article'), array_column($productsArr, 'name'));
			$article_description = implode(', ', array_unique(array_values($article_keywords)));

			array_walk($article_keywords, function(&$item, $key){
				$item = $item . ' ' . $key;
			});
			$meta_keywords = array_merge($meta_keywords, $article_keywords);

            $this->template->content->category_view->current = $current;
            $this->template->content->category_view->parts = $offsets;
            $this->template->content->category_view->cross_products = $product->getCrossProductsData();


		}else
		{
            $this->template->content->category_view->title = 'Детали двигателя';
            $this->template->content->category_view->current = $current;
            $this->template->content->category_view->empty_parts = 'По вашему запросу ничего не найдено, попробуйте ввести еще раз';
		}

		$this->template->meta_keywords = implode(',', $meta_keywords);
		$this->template->meta_description = "Интернет-магазин ФКТ-Автомотив представляет Вам список деталей двигателя {$current['name']} производителя {$current['auto']}. Представлен наиболее полный набор деталей таких как: {$article_description}";
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
            '/categories' => 'Каталог производителей',
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

		$this->template->title = "Каталог производителей";
        $this->template->content = View::factory('templates/second/content');
        $this->template->content->title = 'Каталог производителей';
        $this->template->content->breadcrumbs = View::factory('templates/breadcrumbs');

        $current = $category->getCurrent();
		$offsets = $category->getOffsets();
		if( $type == 'view' )
		{
            Breadcrumbs::set([
	            URL::base() => 'Главная',
	            '/categories' => 'Каталог производителей',
            ]);
            
            $this->template->content->category_view = View::factory('categories/category_view');
            $this->template->content->category_view->title = 'Каталог производителей';
			$meta_keywords = [
				'производители деталей',
				'производители автозапчастей',
				'автозапчасти',
				'детали двигателей всех производителей',
			];

			$this->template->meta_keywords = implode(',', array_merge($meta_keywords, array_column($offsets, 'name')));
			$this->template->meta_description = 'Интернет-магазин автозапчастей и деталей ФКТ-Автомотив предлагает приобрести детали всех известных производителей '.implode(', ', array_column($offsets, 'name'));

		}else if( $type == 'generic' )
		{
            Breadcrumbs::set([
                URL::base() => 'Главная',
                '/categories' => 'Каталог производителей',
                "/categories/view/{$current['name']}"  => $current['name'],
            ]);
            
            $this->template->title = "Каталог моделей производителя {$current['name']}";
            $this->template->content->title = 'Производитель '.$current['name'];
			$this->template->content->category_view = View::factory('categories/category_generic');
			$this->template->content->category_view->title = 'Производитель '.$current['name'];

			$meta_keywords = [
				'производители деталей',
				'производители автозапчастей',
				'автозапчасти',
				'детали двигателей всех производителей',
				'производитель деталей '.$current['name'],
				'модели производителя '.$current['name'],
			];

			$this->template->meta_keywords = implode(',', array_merge($meta_keywords, array_column($offsets, 'name')));
			$this->template->meta_description = 'Производитель автозапчастей и деталей '.$current['name'].' представляет полный набор моделей, от '.current(array_column($offsets, 'name')).' до '.current(array_reverse(array_column($offsets, 'name'), 1));
		}else if( $type == 'engine' )
		{
            Breadcrumbs::set([
                URL::base() => 'Главная',
                '/categories' => 'Каталог производителей',
                "/categories/view/{$current['parentName']}"  => "{$current['parentName']}",
                "/categories/generic/{$current['parentName']}/{$current['name']}"   => $current['name']
            ]);

			$this->template->title = "Каталог двигателей модели {$current['name']}";
            $this->template->content->title = 'Модель '.$current['name'];
			$this->template->content->category_view = View::factory('categories/category_engine');
			$this->template->content->category_view->title = 'Модель '.$current['name'];

			$meta_keywords = [
				'производители деталей',
				'производители автозапчастей',
				'автозапчасти',
				'детали двигателей всех производителей',
				'производитель двигателей двигателя '.$current['parentName'],
				'коды двигателей модели '.$current['name']
			];
			$this->template->meta_keywords = implode(',', array_merge($meta_keywords, array_column($offsets, 'name')));
			$this->template->meta_description = 'Производитель автозапчастей и деталей '.$current['parentName'].' предлагает набор кодов двигателя '.implode(', ',array_column($offsets, 'name')).' модели '.$current['name'];
		}
		
        $this->template->content->category_view->current = $current;
        $this->template->content->category_view->categories = $offsets;
	}
	
	public function filter_categories($type = 'view', $name = NULL)
	{
		$this->response->body('filter categories');
	}

} // End Welcome
