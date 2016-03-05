<?php defined('SYSPATH') or die('No direct script access.');

class Model_Crosses extends MongoModel
{
	protected $_collection_name = 'crosses';
	
	
	protected $_schema = array(
		'date_create'	=> 'date',
		'article'	=> 'string',
		'clear_article'	=> 'string',
		'category'	=> 'string',
		
		'parentName'	=> 'string',
		'cross_article'	=> 'string',
		'name'	=> 'string',
		'parentId'	=> 'string',
		'manufacture'	=> 'string',
		'groupName'	=> 'string',
		'groupId'	=> 'string',
		'search_article'	=> array(
			'_keys'	=> 'string'
		),
		'link'	=> 'string',
	);
	
	
}