<?php defined('SYSPATH') or die('No direct script access.');

class Model_Message extends MongoModel
{
    protected $_collection_name = 'messages';


    protected $_schema = array(
        'date_create'	=> 'date',
        'username'  => 'string',
        'useremail' => 'string',
        'useremsg'  => 'string'
    );


}