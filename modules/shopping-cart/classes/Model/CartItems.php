<?php defined('SYSPATH') OR die('No direct script access.');
	
class Model_CartItems extends MongoModel
{
	protected $_collection_name = 'shopping_cart_items';
	
	
	protected $_schema = array(
		'id'	=> 'string',
		'article'	=> 'string',
		'qty'	=> 'int',
		'price'	=> 'double',
		'name'	=> 'string',
		'_cartId'	=> 'id'
	);
}