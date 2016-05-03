<?php defined('SYSPATH') OR die('No direct script access.');

class Controller_Page_Cart extends Cart
{
	/**
	 * Template view
	 * @var string $template String name of the template
	 */
	public $template = 'templates/second/main';
	
	public $auto_render = TRUE;

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
	        $this->template->meta_copywrite   = '';
	        $this->template->header           = '';
	        $this->template->content          = '';
	        $this->template->footer           = '';
	        $this->template->styles           = [];
	        $this->template->scripts          = [];
        }
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
				'assets/css/common_style.css'  => 'all',
				'assets/css/sidebar.css'  => 'all',
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
                    'assets/js/second.js'
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
		$this->template->header = View::factory('templates/second/header');
        $this->template->footer = View::factory('templates/second/footer');
        
		$this->template->content = View::factory('page/main');
		$this->template->content->cart_view = View::factory('page/shopcart');
		$this->template->content->breadcrumbs = View::factory('templates/breadcrumbs');
		
		Breadcrumbs::set([
            URL::base() => 'Главная',
            '/cart' => 'Корзина заказов',
        ]);
		
		$this->template->title = 'Ваша корзина заказов в Интернет-магазине деталей Hammerschmidt';
		$this->template->content->cart_view->title = 'Корзина заказов';
		

		$cartContent = $this->_cart->getProductContent();

		if( !empty($cartContent) && isset($cartContent['total']) && $cartContent['total']['count'] > 0 )
		{
			$this->template->content->cart_view->cart = $this->_cart->getProductContent();	
		}else
		{
			$this->template->content->cart_view->cart = [];
			$this->template->content->cart_view->empty_cart = 'Ваша корзина деталей пустая, '.HTML::anchor('/categories', 'вернитесь к покупкам');
		}
	}
}