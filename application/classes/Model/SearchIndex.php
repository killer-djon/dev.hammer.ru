<?php defined('SYSPATH') or die('No direct script access.');

class Model_SearchIndex extends MongoModel
{
	protected $_collection_name = 'search_index';
	
	
	protected $_schema = array(
		'collection'	=> 'string', // collection name for search
		'field'			=> 'string', // field name for search on collection
		'type'			=> 'string', // search type
		'value'			=> 'string', // value of search 
		'search_count'	=> 'int', // search count this value
		'first_search'	=> 'date', // first date search
		'last_search'	=> 'date', // last date search
		'search_page'	=> 'string', // from which page will start search
	);
}
