<?php defined('SYSPATH') OR die('No direct script access.');
	
class Model_Cart extends MongoModel
{
	protected $_collection_name = 'shopping_cart';
	
	
	protected $_schema = array(
		'product_id'	=> 'string',
		'article'	=> 'string',
		'qty'	=> 'int',
		'price'	=> 'double',
	);
}