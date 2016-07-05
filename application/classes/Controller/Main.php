<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Main extends Controller_Template  
{

	protected $_cache = NULL;

	public $template = 'templates/default';

	public function before()
	{
		parent::before();

        if($this->auto_render)
        {
            // Initialize empty values
	        $this->template->title            = '';
			$this->template->breadcrumbs      = '';
	        $this->template->meta_keywords    = '';
	        $this->template->meta_description = '';
	        $this->template->meta_copywrite   = 'Интернет-магазин автодеталей ФКТ-Автомотив';
	        $this->template->header           = '';
	        $this->template->content          = '';
	        $this->template->footer           = '';
	        $this->template->styles           = [];
	        $this->template->scripts          = [];
        }
        
        //$this->_cache = Cache::instance('redis');
	}

    public function setScript( $scriptSrc = NULL, $path = 'header' )
    {
        if( !is_null($scriptSrc) )
        {
	        
            $this->template->scripts[$path] = ( is_string($scriptSrc)
                ? [$scriptSrc]
                : (is_array($scriptSrc) ? $scriptSrc : []) );
            
            
        }
    }


	public function setStyle( $hrefSrc = NULL, $media = 'all' )
	{
		if( !is_null( $hrefSrc ) )
		{
			$this->template->styles = ( is_string($hrefSrc)
                ? [$hrefSrc => $media]
                : (is_array($scriptSrc) ? $scriptSrc : []) );
			
			//'assets/css/sidebar.css'  => 'all',
		}
		
	}

	
	public function after()
	{
		if($this->auto_render)
        {
             // Define defaults
            $styles = [
				'assets/css/font-awesome.min.css'  => 'all',
				'assets/css/bootstrap.min.css'  => 'all',
				'assets/css/animate.css'  => 'all',
				'assets/css/common_style.css'  => 'all',
				'assets/css/responsive.css'  => 'all',
				'http://fonts.googleapis.com/css?family=Open+Sans:600italic,400,800,700,300'  => 'all'
			];

            $scripts = [
				'header'	=> [
					'assets/js/modernizr.js',
				],
				'footer'	=> [
					'assets/js/jquery-2.1.1.js',
                    'assets/js/smoothscroll.js',
                    'assets/js/bootstrap.min.js',
                    'assets/js/wow.js',
                    'assets/js/detectmobile.js',
				]
			];

             // Add defaults to template variables.
            $this->template->styles  = array_reverse(array_merge($this->template->styles, $styles));
            $this->template->scripts = array_merge_recursive($scripts, $this->template->scripts);

        }

         // Run anything that needs to run after this.
        parent::after();
	}
	
	public function action_index()
	{
		//$this->template->content = 'Главная';
		
	}

} // End Welcome
