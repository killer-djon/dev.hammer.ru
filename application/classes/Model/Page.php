<?php defined('SYSPATH') or die('No direct script access.');
	
	
class Model_Page extends MongoModel
{
	protected $_collection_name = 'pages';
	
	
	protected $_schema = array(
		"id" => 'string',
		"pagetitle" => 'string',
		"description" => 'string',
		"pagealias" => 'string',
		"menutitle" => 'string',
		"metakeywords" => 'string',
		"metadescription" => [
			'_keys'	=> 'string'
		],
		"metatitle" => 'string',
		"pagecontent" => 'string',
		"menuindex" => 'int',
		"parentId" => 'string',
		"published" => 'bool',
		"registered" => 'bool',
		"datecreate" => 'date',
		"dateupdate" => 'date',
		"showmenu" => 'bool',
		"leaf" => 'bool',
		"allowChildren" => 'bool',
		"mainpage" => 'bool',
		"description_img" => 'string'
	);
}