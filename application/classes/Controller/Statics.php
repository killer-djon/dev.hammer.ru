<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Statics extends Controller_Main
{
	
	

	public function action_index()
	{
		$params = $this->request->param('static');
		if( !empty($params) )
		{
			
		}else
		{
			$category = Category::getInstance();
			$category->getCategories('view', NULL); // get default view categories - first levent
		
			$this->template->title = 'Производители';
			$this->template->content = View::factory('categories/category_view');
			$this->template->content->categories = $category->getOffsets();
		}
		
	}
	
	
	
	public function render_static($params = NULL)
	{
		
	}

} // End Welcome
