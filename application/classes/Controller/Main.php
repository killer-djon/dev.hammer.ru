<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Main extends Controller_Template  
{

	public $template = 'templates/default';

	public function before()
	{
		parent::before();

        if($this->auto_render)
        {
            // Initialize empty values
	        $this->template->title            = '';
	        $this->template->meta_keywords    = '';
	        $this->template->meta_description = '';
	        $this->template->meta_copywrite   = '';
	        $this->template->header           = '';
	        $this->template->content          = '';
	        $this->template->footer           = '';
	        $this->template->styles           = array();
	        $this->template->scripts          = array();
        }
	}
	
	
	
	public function after()
	{
		if($this->auto_render)
        {
             // Define defaults
            $styles = array('assets/css/reset.css' => 'screen');
            $scripts = array('assets/js/jquery-2.2.0.min.js');

             // Add defaults to template variables.
            $this->template->styles  = array_reverse(array_merge($this->template->styles, $styles));
            $this->template->scripts = array_reverse(array_merge($this->template->scripts, $scripts));
        }

         // Run anything that needs to run after this.
        parent::after();
	}
	
	public function action_index()
	{
		$this->template->content = 'Главная';
	}

} // End Welcome
