<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Api_CrossHammer extends Controller_Rest
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
        parent::before();

        $this->reflection = new ReflectionClass($this->request);

        $this->_model = MongoModel::factory('HammerCrosses');
        $this->_model->selectDB();
    }

    /**
     * Получаем пписок деталей
     */
    public function action_index()
    {
        $this->_limit = $this->_params['limit'] ?: 'all';
        $this->_page = $this->_params['page'] ?: 1;
        $this->_skip = $this->_params['start'] ?: 0;
        $file_id = !empty($this->_params['file_id']) ? $this->_params['file_id'] : null;

        if (empty($file_id)) {
            return;
        }
        try {


            $items = $this->_model
                ->where('file_id', '=', $file_id)
                ->limit($this->_limit)
                ->skip($this->_skip)
                ->find_all();

            $this->rest_output([
                'success' => true,
                'items'   => $items
            ]);

        } catch (Kohana_Database_Exception $e) {
            $this->rest_output([
                'success' => false,
                'code'    => $e->getMessage()
            ]);
        }
    }

    /**
     * Создаем деталь
     */
    public function action_create()
    {

    }

    /**
     * Обновляем данные детали
     */
    public function action_update()
    {
        print_r( $this->_params );
    }

    /**
     * Удаляем кросс деталь из базы
     */
    public function action_delete()
    {
        try{
            $file_id = $this->_params['file_id'];
            $id = $this->_params['id'];

            $removed = $this->_model->where('_id', '=', new MongoId($id))->remove();

            if( $removed )
            {
                $this->rest_output([
                    'success' => true
                ]);
            }

        }catch(Kohana_Database_Exception $e)
        {
            $this->rest_output([
                'success' => false,
                'code'    => $e->getMessage()
            ]);
        }catch(Kohana_Exception $e)
        {
            $this->rest_output([
                'success' => false,
                'code'    => $e->getMessage()
            ]);
        }
    }
}