<?php defined('SYSPATH') or die('No direct script access.');

class Model_CrossProducts extends MongoModel
{
	protected $_collection_name = 'cross_products';
	
	
	protected $_schema = [
		"identifier" => 'string',
        "article" => 'string',
        "manufacture" => 'string',
        "name" => 'string',
        "clear_article" => 'string',
        "parentName" => 'string',
        "parentId" => 'string',
        "groupName" => 'string',
        "category" => 'string',
        "link" => 'string',
        "date_create" => 'date',
        "cross_article" => [
	        '_keys'	=> 'string'
        ]
	];
}
