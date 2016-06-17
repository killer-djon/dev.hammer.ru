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
		$sessionData = Session::instance();
		$this->template->header = View::factory('templates/second/header');
        $this->template->footer = View::factory('templates/second/footer');
        
		$this->template->content = View::factory('page/main');
		$this->template->content->cart_view = View::factory('page/shopcart');
		$this->template->content->breadcrumbs = View::factory('templates/breadcrumbs');

		$cartModel = MongoModel::factory('CartUser');
		$cartModel->selectDB();
		
		Breadcrumbs::set([
            URL::base() => 'Главная',
            '/cart' => 'Корзина заказов',
        ]);
        
		$this->template->title = 'Корзина заказов в Интернет-магазине деталей Hammerschmidt';
		$this->template->content->cart_view->title = 'Корзина заказов';
		

		$cartContent = $this->_cart->getProductContent();


		if( !empty($cartContent) && isset($cartContent['total']) && $cartContent['total']['count'] > 0 )
		{
			$userData = $cartModel->where('_id', '=', $cartContent['cartId'])->find();
			$this->template->content->cart_view->cart = $cartContent;
			$this->template->content->cart_view->userdata = $userData->user_data;
		}else
		{
			$this->template->content->cart_view->cart = [];
			$this->template->content->cart_view->empty_cart = 'Необходимо выбрать и добавить детали в корзину, а затем перейти в корзину заказов и завершить процесс покупки. '.HTML::anchor('/categories', 'вернитесь к покупкам');
		}
	}
	
	public function action_checkout()
	{
		$checkoutData = $this->request->post();
		$sessionData = Session::instance();
		
		$cartCheckout = [
			'userdata'	=> $checkoutData,
			'cartcontent'	=> $sessionData->get('hammer_shop_cart')
		];

		$cartModel = MongoModel::factory('CartUser');
		$cartModel->selectDB();

		if( !empty( $cartCheckout ) )
		{
			$cartId = $this->_cart->getCartId();
			if( !is_null($cartId) && $cartId instanceof MongoId )
			{
				$record = $cartModel->where('_id', '=', $cartId)->find();
				if( $record->loaded() )
				{
					$record
						->set('total', $cartCheckout['cartcontent']['total'])
						->set('user_data', $checkoutData)
						->save();
				}
			}else
			{
				$cartModel
					->set('shopping_date', new MongoDate())
					->set('shopping_end', false)
					->set('user_data', $checkoutData)
					->set('total', $cartCheckout['cartcontent']['total']);

				$record = $cartModel->save();
				$this->checkout( $record->get('_id') );
			}

			$this->template->header = View::factory('templates/second/header');
			$this->template->footer = View::factory('templates/second/footer');

			$this->template->content = View::factory('page/main');
			$this->template->content->cart_view = View::factory('page/approvecart');
			$this->template->content->breadcrumbs = View::factory('templates/breadcrumbs');

			Breadcrumbs::set([
				URL::base() => 'Главная',
				'/cart' => 'Корзина заказов',
				'/cart/success'	=> 'Подтверждение заказа'
			]);

			$cartModel = MongoModel::factory('CartUser');
			$cartModel->selectDB();

			$cartContent = $this->_cart->getProductContent();
			$this->template->title = 'Подтверждение Вашего заказа в Интернет-магазине деталей Hammerschmidt';
			$this->template->content->cart_view->title = 'Подтверждение заказа';

			if( !empty($cartContent) && isset($cartContent['total']) && $cartContent['total']['count'] > 0 )
			{
				$userData = $cartModel->where('_id', '=', $cartContent['cartId'])->find();

				$this->template->content->cart_view->cart = $cartContent;
				$this->template->content->cart_view->userdata = $userData->user_data;
			}else
			{
				$this->template->content->cart_view->cart = [];
				$this->template->content->cart_view->empty_cart = 'Необходимо выбрать и добавить детали в корзину, а затем перейти в корзину заказов и завершить процесс покупки. '.HTML::anchor('/categories', 'вернитесь к покупкам');
			}

		}
	}


	public function action_success()
	{
		$cartContent = $this->_cart->getProductContent();
		
		$cartModel = MongoModel::factory('CartUser');
		$cartModel->selectDB();
		
		$number = $cartModel->where('_id', '=', $cartContent['cartId'])->count();
		$userData = $cartModel->where('_id', '=', $cartContent['cartId'])->find();
		
		$mailConfig = Kohana::$config->load('cart')->as_array();

		$mailer = Email::instance('sendmail');
		$message = Swift_Message::newInstance();

		$message
			->setSubject('Поступил новый заказ № '.$number)
			->setTo($mailConfig['emailTo'])
			->setFrom($mailConfig['emailFrom'])
			->setBody(
				View::factory(
					$mailConfig['emailTemplate'],
					[
						'title'	=> 'Информация по заказу № 000'.$number,
						'cart'	=> $cartContent,
						'userdata'	=> $userData->user_data,
						'base_url'	=> URL::base(),
						'thanks'	=> '
							<h4>Спасибо что воспользовались нашими услугами.</h4> <p>Ждем Вас снова в нашем интернет-магазине деталей. 
							Если появились вопросы или хотите поделиться своими впечатлениями пишитем нам на email: info@hammerschmidt.ru.</p>'
					]
				)
					->render(),
				'text/html'
			);

		$clientMessage = Swift_Message::newInstance();
		$clientMessage
			->setSubject('Оформленный Вами заказ № 000'.$number.' в интернет-магазине HAMMERSCHMIDT')
			->setTo([$userData->user_data['useremail']	=> $userData->user_data['username']])
			->setFrom($mailConfig['emailFrom'])
			->setBody(
				View::factory(
					$mailConfig['emailTemplate'],
					[
						'title'	=> 'Информация по заказу № 000'.$number,
						'cart'	=> $cartContent,
						'userdata'	=> $userData->user_data,
						'base_url'	=> URL::base(),
						'thanks'	=> '
							<h4>Спасибо что воспользовались нашими услугами.</h4> <p>Ждем Вас снова в нашем интернет-магазине деталей. 
							Если появились вопросы или хотите поделиться своими впечатлениями пишитем нам на email: info@hammerschmidt.ru.</p>'
					]
				)
					->render(),
				'text/html'
			);

		$admin = $mailer->send($message);
		$client = $mailer->send($clientMessage);

		if( $admin > 0 && $client > 0 )
		{
			$cartItemsModel = MongoModel::factory('CartItems');
			$cartItemsModel->selectDB();

			foreach( $cartContent['products'] as $key => $item )
			{
				$item['_cartId'] = $cartContent['cartId'];
				
				$cartItemsModel->values($item);
				$cartItemsModel->save();
			}

			$this->_cart->clear();

			$this->template->header = View::factory('templates/second/header');
			$this->template->footer = View::factory('templates/second/footer');

			$this->template->content = View::factory('page/main');
			$this->template->content->cart_view = View::factory('page/success');
			$this->template->content->breadcrumbs = View::factory('templates/breadcrumbs');

			Breadcrumbs::set([
				URL::base() => 'Главная',
				'/categories' => 'Каталог производителей',
			]);

			$this->template->content->cart_view->title = 'Заказ успешно оформлен';
		}
	}
}