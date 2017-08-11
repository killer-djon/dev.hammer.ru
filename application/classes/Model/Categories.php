<?php defined('SYSPATH') or die('No direct script access.');

class Model_Categories extends MongoModel
{
	protected $_collection_name = 'categories';
	
	
	protected $_schema = array(
		'auto'	=> 'string',
		'name'	=> 'string',
		'clear_name' => 'string',
		'link'	=> 'string',
		'cilinder' => 'int',
        'clapan_per_cilinder' => 'int',
        'diametr_porshen' => 'double',
        'hod_porshen' => 'double',
        'work_obiem' => 'int',
        'param' => 'string',
        'fluent'	=> 'string',
        'parentName'	=> 'string',
        
		"parentId" => "string",
		"clearname" => "string",
		
		"date_create" =>  "date",
		"date_update"	=> "date"
	);
	
	
	
	public function filters()
	{
		return array(
			'date_update'	=> new MongoDate()
		);
	}
	
}
