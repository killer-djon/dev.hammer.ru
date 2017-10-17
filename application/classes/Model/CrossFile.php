<?php defined('SYSPATH') or die('No direct script access.');

class Model_CrossFile extends MongoModel
{
    /**
     * @var string Название коллекции
     */
    protected $_collection_name = 'cross_files';


    /**
     * Маппинг полей коллекции
     * @var array
     */
    protected $_schema = [
        'name' => 'string',
        'type' => 'string',
        'size' => 'int',
        'createdAt' => 'date',
        'leaf' => 'bool'
    ];
}