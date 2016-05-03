<?php defined('SYSPATH') OR die('No direct script access.');

abstract class Cart extends Kohana_Cart
{
		
	
	public function before()
	{
		$this->_cart = IOCart::getInstance();
		parent::before();
	}
}