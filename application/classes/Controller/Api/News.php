<?php defined('SYSPATH') or die('No direct script access.');
	
class Controller_Api_News extends Controller_Rest
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
	private $_id = NULL;
	
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
	private $_parentAlias = 'news';
	
	/**
	 * Parent document getted by parenAlias
	 *
	 * @var mixed|array
	 */
	private $_parent = NULL;
	
	/**
	 * Initialize the example model.
	 */
	public function before()
	{
		$this->reflection = new ReflectionClass($this->request);
		
		
		$modelName = $this->request->controller();
		$this->_model = MongoModel::factory($modelName);
		$this->_model->selectDB();
		
		$id = $this->request->param('id');
		$this->_id = !empty($id) ? new MongoId($id) : '';
		
		$this->_limit = $this->request->param('item_per_page') ?: 'all';
		$this->_page = $this->request->param('page') ?: 1;
		$this->_skip = ($this->_page - 1) * $this->_limit;
		
		$this->_parent = $this->_model
			->where('pagealias', '=', $this->_parentAlias)
			->find()
			->getSingleDocument();
		
		$this->_model->unload();
		parent::before();
	}
	
	public function action_index()
	{
		try
		{
			if( !empty( $this->_id ) )
			{
				$this->_model
					->where('_id', '=', $this->_id)
					->find();
				
				$items = $this->_model->getSingleDocument();
				
				$this->rest_output([
					'items'	=> $items,
					'pagination'	=> [],
					'_meta'	=> [
						'_link'	=> URL::site($this->_parent['pagealias'])
					]
				]);
			}else
			{
				
				$cnt = $this->_model->where('parentId', '=', $this->_parent['_id']['$id'])->count();
				//$this->_model->unload();
				
				$this->_model->where('parentId', '=', $this->_parent['_id']['$id']);
				if( 'all' != $this->_limit )
				{	
					$this->_model->limit($this->_limit);
					$this->_model->skip($this->_skip);
				}
				
				$items = $this->_model->find_all();
				
				$this->rest_output([
					'items'	=> $items,
					'pagination'	=> [
						'item_per_page'	=> ( 'all' != $this->_limit ? (int)$this->_limit: count($items) ),
						'total_items'	=> $cnt,
						'current_page'	=> $this->_page
					],
					'_meta'	=> [
						'_link'	=> URL::site($this->_parent['pagealias'])
					]
				]);
			}
		}
		catch (Kohana_HTTP_Exception $khe)
		{
			$this->_error($khe);
		}
		catch (Kohana_Exception $e)
		{
			$this->_error('An internal error has occurred', 500);
		}
	}
}