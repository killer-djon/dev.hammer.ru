<?php defined('SYSPATH') or die('No direct script access.');
	
class Model_Prices extends MongoModel
{
	protected $_collection_name = 'prices';
	
	
	protected $_schema = array(
		'date_create'	=> 'date',
		'name'	=> 'string',
		'article'	=> 'string',
		
		'clear_article'	=> 'string',
		'manufacture'	=> 'string',
		'qty'	=> 'int',
		'price'	=> 'double'
	);
}