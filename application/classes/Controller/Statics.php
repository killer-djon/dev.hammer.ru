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
		$this->template->content = View::factory('templates/main/content');
		
		$params = $this->request->param('static');
		if( !empty($params) )
		{
			
		}else
		{
			$category = Category::getInstance();
			$category->getCategories('view', NULL); // get default view categories - first levent

			$this->template->title = 'Интернет-магазин деталей всех производителей';
			//$this->template->content = View::factory('categories/category_view');
			$this->template->content->categories = $category->getOffsets();
		}
		
	}
	
	
	
	public function render_static($params = NULL)
	{
		
	}

} // End Welcome
