<?php defined('SYSPATH') or die('No direct script access.');

class Model_Exports1C extends MongoModel
{
    protected $_collection_name = 'export_1c';


    protected $_schema = array(
        'file_format'   => 'string',
        'file_size' => 'int',
        'file_name' => 'string',
        'file_path' => 'string',
        'date_upload'   => 'date',
        'date_integrate'    => 'date'
    );

}
