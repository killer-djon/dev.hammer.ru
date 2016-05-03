<?php defined('SYSPATH') OR die('No direct script access.');
	
class IOCart extends Kohana_IOCart
{
	
	/**
	 * Self instance
	 * @var Kohana_IOCart $_instance
	 */
	protected static $_instance = NULL;
	
	
	public static function getInstance()
	{
		if( is_null( self::$_instance ) )
		{
			self::$_instance = new self;
		}
		
		return self::$_instance;
	}	
	
	private function __construct()
	{
		// Load configuration
		$this->_config = Kohana::$config->load('cart')->as_array();
		
		// Load Session object
		$this->_session = Session::instance($this->_config['session']['type']);
		
		// Grab the shopping cart array from the session table, if it exists
		if ( ! $this->_content = $this->_session->get($this->_config['session']['key']))
		{
			// Cart not exists, set basic values
			$this->_content = array(
				'products' => array(),
				'total'    => array('price' => 0, 'count' => 0, 'discount' => 0),
			);
		}
	}
}