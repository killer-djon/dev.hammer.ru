<?php defined('SYSPATH') or die('No direct script access.');

class Model_LastStep extends MongoModel
{
	protected $_collection_name = 'last_step';
	
	
	protected $_schema = array(
		'url'	=> 'string',
		'title'	=> 'string',
		'type'	=> 'string',
		'name'	=> 'string',
		'metadata'	=> array(
			'_keys'	=> 'string'
		)
	);
		
}
