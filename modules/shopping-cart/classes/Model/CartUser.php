<?php defined('SYSPATH') OR die('No direct script access.');
	
class Model_CartUser extends MongoModel
{
	protected $_collection_name = 'shopping_cart_user';
	
	
	protected $_schema = array(
		'cart_id'	=> 'string',
		'shopping_date'	=> 'date',
		'shopping_end'	=> 'bool',
		'user_data'	=> [
			'_keys'	=> 'string'
		],
		'total'	=> [
			'_keys'	=> 'string'
		]
	);
}