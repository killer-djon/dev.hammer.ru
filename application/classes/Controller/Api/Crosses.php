<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Api_Crosses extends Controller_Rest
{
    /**
     * Set the authentication type.
     *
     * @var string
     */
    protected $_auth_type = RestUser::AUTH_TYPE_OFF;


    /**
     * MongoModel instance
     *
     * @var MongoModel
     */
    private $_model;

    /**
     * ReflectionClass
     *
     * @var ReflectionClass
     */
    private $reflection;

    /**
     * MongoId
     *
     * @var MongoId
     */
    private $_id = null;

    /**
     * Current page number
     *
     * @var integer
     */
    private $_page = 1;

    /**
     * Limit of the recors
     *
     * @var integer|string
     */
    private $_limit = 'all';

    /**
     * Current number to skip record
     *
     * @var integer
     */
    private $_skip = 0;

    /**
     * Parent document alias name
     *
     * @var string
     */
    private $_parentAlias = 'crosses';

    /**
     * Parent document getted by parenAlias
     *
     * @var mixed|array
     */
    private $_parent = null;

    /**
     * A Restexample model instance for all the business logic.
     *
     * @var Model_AuthUser
     */
    protected $_rest;

    /**
     * Initialize the example model.
     */
    public function before()
    {
        echo '<pre>';
        parent::before();

        $this->reflection = new ReflectionClass($this->request);

        $this->_model = MongoModel::factory('HammerCrosses');
        $this->_model->selectDB();

    }

    /**
     * Запросы GET на получение данных
     * @
     */
    public function action_index()
    {
        $requestMethod = $this->request->method();
        if (in_array($requestMethod, ['GET', 'OPTIONS'])) {

        }
    }

    public function action_upload()
    {
        $requestMethod = $this->request->method();
        if ($requestMethod != 'POST') {
            return false;
        }

        print_r( $this->request );
    }

    public function action_update()
    {

    }

    public function action_delete()
    {

    }
}

    
    