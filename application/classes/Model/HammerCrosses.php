<?php defined('SYSPATH') or die('No direct script access.');

class Model_HammerCrosses extends MongoModel
{
    protected $_collection_name = 'hammer_crosses';


    protected $_schema = array(
        'date_create'	=> 'date',
        'article'	=> 'string',
        'clear_article'	=> 'string',
        'hash_article' => 'string',
        'name' => 'string',
        'cross_article' => [
            '_keys' => 'string'
        ],
        'manufacture' => 'string',
        'file_id' => 'string',
        'qty' => 'int',
        'price' => 'double'
    );


}