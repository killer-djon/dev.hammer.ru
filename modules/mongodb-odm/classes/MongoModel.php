<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * [Object Document Mapping][ref-odm] (ODM) is a method of abstracting
 * MongoDB access to standard PHP calls. Documents
 * are represented as model objects, with object properties
 * representing document fields.
 *
 * @package ODM
 */
class MongoModel extends ODM 
{
	
	/**
	 * The database instance
	 * @var MongoClient
	 */
	protected $_db;
	
	/**
	 * The database instance
	 * @var MongoClient
	 */
	protected $_client;
	
	
	protected static $_config;
	
	/**
	 * @var KohanaConfig
	 */
	protected $_config_base;
	
	/**
	 * Collection name
	 * @var String
	 */
	protected $_collection_name;
	
	protected $_type = array(
		'boolean'	=> 'bool',
		'integer'	=> 'int',
		'string'	=> 'string',
		'null'		=> 'string',
		'double'	=> 'double'
	);
	
	public function setCollectionName($collection)
	{
		
		$this->_collection_name = $collection;
	}
	
	public function __construct()
	{
		parent::__construct();
		$this->_connect();
	}
	
	/**
	 * Prepares the model database connection
	 */
	public function _connect($config = array())
	{
		$options = array();
		
		if( !is_array($config) || !count($config) )
		{
			$config = Kohana::$config->load('database')->{$this->_db_group};
			$this->_config_base = $config;
		}
		
		$_connection_string = $this->_parse_connection($config);
		
		if( Arr::path($config, 'options.replica') )
		{
			$options['replicaSet'] = Arr::path($config, 'options.replicaSet');
			
			$reads = Arr::path($config, 'options.readPreference');
			$options['readPreference'] = (isset($reads)&& !empty($reads) ? $reads : MongoClient::RP_PRIMARY_PREFERRED);
		}
		
		if( Arr::path($config, 'options.auth') )
		{

			$options = array_merge($options, array(
				'authMechanism' => Arr::path($config, 'options.authMechanism'),
				'db'		=> Arr::path($config, 'options.db'),
				'username'	=> Arr::path($config, 'options.username'),
				'password'	=> Arr::path($config, 'options.password'),
			));
		}
		
		if ( ! $this->_client )
		{
			$this->_client = new MongoClient($_connection_string, $options);
		}
		
		return $this->_client->connect();
	}
	
	public function createSchema( array $_schema = array() )
	{
		if( !count( $_schema ) )
		{
			$this->_schema = false;
		}
		
		if( is_array($this->_schema) && count($this->_schema) )
		{
			$schema = array_merge($this->_schema, $_schema);
		}
		
		$schema = $_schema;
		
		foreach( $schema as $key => $item )
		{
			
			$type = gettype($item);

			if( array_key_exists($type, $this->_type) )
			{
				$this->_schema[$key] = $this->_type[gettype($item)];
			}
			
			if( $type == 'array' || $type == 'object' )
			{
				$this->_schema[$key] = array(
					'_keys'	=> 'string'
				);
			}
			
			if( is_null($type) || stripos('null', $type) !== false )
			{
				$this->_schema[$key] = 'string';
			}
		}
	}
	
	public function selectDB($dbname = '')
	{
		if( empty($dbname) )
		{
			$dbname = Arr::path($this->_config_base, 'options.db');
		}
		
		if( ! $this->_db  )
		{
			$this->_db = $this->_client->selectDB($dbname);
		}
	}
	
	
	private function _parse_connection(array $config)
	{
		$_connection_string = "mongodb://";
		
		if( !count($config) )
		{
			throw new Model_Exception("Can't parse those connection string :connection", array(
				':connection'	=> $config
			));
		}
		
		$hostname = Arr::get($config, 'hostname');
		$portnumber = Arr::get($config, 'port');
		
		if( stripos($hostname, 'mongo') !== false )
		{
			$hostname = substr($hostname, stripos($hostname, '//')+2, strlen($hostname));
		}

		$host = explode(",", $hostname);
		
		$_hostname = array();
		
		if( !is_array($host) )
		{
			throw new Model_Exception("You not set hostname to connect MongoDB", array(
				':connection'	=> $config
			));
		}
		
		foreach( $host as $key => $item )
		{
			$__serv = explode(":", $item);
			if( count($__serv) <= 1 )
			{
				//$_connection_string .= $item.":".$portnumber;
				$_hostname[] = $item.":".$portnumber;
			}else
				$_hostname[] = $item;
		}
		
		$_connection_string .= implode(",", $_hostname);
				
		return $_connection_string;
	}
	
}