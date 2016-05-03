<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Statics extends Controller_Main
{
	public $template = 'templates/main/main';
	
	
	/*public function after()
    {
        $this->template->header = View::factory('templates/main/header');
        $this->template->footer = View::factory('templates/main/footer');

        parent::after();

    }*/

	public function action_index()
    {
        
		
		$params = $this->request->param('static');
		if( !empty($params) )
		{
			$this->setScript('assets/js/second.js', 'footer');
			$this->setStyle('assets/css/sidebar.css', 'all');
			
			$this->template->header = View::factory('templates/second/header');
			$this->template->footer = View::factory('templates/second/footer');
			
			$this->render_static();
		}else
		{
			$this->setScript('assets/js/custom.js', 'footer');
			$this->template->header = View::factory('templates/main/header');
			$this->template->footer = View::factory('templates/main/footer');
        
			$category = Category::getInstance();
			$category->getCategories('view', NULL); // get default view categories - first levent
			
			$this->template->content = View::factory('templates/main/content');
			$this->template->title = 'Интернет-магазин деталей всех производителей';

			$this->template->content->categories = $category->getOffsets();
			return $this->response->body($this->template);
			
		}
		
	}
	
	public function render_static()
	{
		
		$route = $this->request->uri();
		
		$modelPage = MongoModel::factory('Page');
		$modelPage->selectDB();
		
		$page = $modelPage
			->where('pagealias', '=', $route)
			->find();

		$this->template->content = View::factory('pages/content');
		$this->template->content->breadcrumbs = View::factory('templates/breadcrumbs');
		
		if( $page->loaded() )
		{
			$singlePage = $page->getSingleDocument();
			$modelPage->unload();
			
			Breadcrumbs::set([
	            URL::base() => 'Главная',
	            '/'.$singlePage['pagealias'] => 'Автоновости',
	        ]);
			
			$this->template->content->category_view = View::factory($singlePage['template']);
			
			$singlePage['children'] = $modelPage
				->where('parentId', '=', $singlePage['_id']['$id'])
				->find_all();
			
			$this->template->title = $singlePage['metatitle'];
			$this->template->meta_keywords = $singlePage['metakeywords'];
			$this->template->meta_description = $singlePage['metadescription'];
			
			$this->template->content->category_view->page = $singlePage;			
			
			return $this->response
				->status(200)
				->body($this->template);
		}else
		{
			Breadcrumbs::set([
	            URL::base() => 'Главная',
	        ]);
	        
			$this->template->content->category_view = View::factory('templates/errors/404');
			$this->template->content->category_view->page = [];
			
			return $this->response
				->status(404)
				->body($this->template);
		}
		
	}

} // End Welcome
