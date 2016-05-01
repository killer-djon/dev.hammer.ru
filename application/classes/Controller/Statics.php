<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Statics extends Controller_Main
{
	public $template = 'templates/main/main';
	
	
	public function after()
    {
        $this->template->header = View::factory('templates/main/header');
        $this->template->footer = View::factory('templates/main/footer');

        parent::after();

    }

	public function action_index()
    {
        $this->setScript('assets/js/custom.js', 'footer');
		
		$params = $this->request->param('static');
		if( !empty($params) )
		{
			$this->render_static();
		}else
		{
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
		$this->template->content = $route;
		return $this->response->body($this->template);
	}

} // End Welcome
