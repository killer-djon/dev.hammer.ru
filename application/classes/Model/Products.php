<?php defined('SYSPATH') or die('No direct script access.');

class Model_Products extends MongoModel
{
	protected $_collection_name = 'products';
	
	
	protected $_schema = array(
		'category'	=> 'string',
		'parentId'	=> 'string',
		'parentName'	=> 'string',
		'date_create'	=> 'date',
		
		'name'	=> 'string',
		'article'	=> 'string',
		'clear_article'	=> 'string',
		'manufacture'	=> 'string',
		'groupName'	=> 'string',
		'groupId'	=> 'string',
		'search_article'	=> array(
			'_keys'	=> 'string'
		),
		'qty'	=> 'int',
		'price'	=> 'string',
		'link'	=> 'string',
		'type'	=> 'string', // this type must be product or cross
	);
	
	
	
}