<?php defined('SYSPATH') or die('No direct script access.');

use League\OAuth2\Client\Token\AccessToken;

abstract class Kohana_Account
{

	/**
	 * @var Account instance	
	 */
	protected static $_instance = NULL;
	
	/**
	 * @var Session kohana storage
	 */
	protected static $_storage = NULL;
	
	/**
	 * @var array response
	 */
	protected $_response = NULL;
	
	
	/**
	 * @var AccessToken object
	 */
	protected $_token = NULL;
	
	
	/**
	 * Return authorization data
	 * from session storage from auth	
	 */
	public function getAuthData()
	{
		return Session::instance()->get('auth');
	}
	
	
	/**
	 * Create static instance
	 * and manipulate with data from there
	 *
	 * @param array $response incomming response from method create owner
	 * @param AccessToken $token AccessToken instance
	 *
	 * @return static
	 */
	public static function getInstance(array $response = [], AccessToken $token = NULL)
	{
		if( is_null( static::$_instance ) )	
		{
			static::$_instance = new static($response, $token);
		}
		
		return static::$_instance;
	}
	
	
	/**
	 * Set objects in instance
	 *
	 * @param array $response incomming response from method create owner
	 * @param AccessToken $token AccessToken instance
	 */
	public function __construct(array $response = [], AccessToken $token = NULL)
	{
		Session::instance()->delete('auth');
		
		$this->setResponse($response);
	}
	
	
	/**
	 * If instance of the static class 
	 * create empty (without args)
	 * then in the futures we must call setters for those args
	 *
	 * @param array $response incomming response from method create owner
	 *
	 * @return static
	 */
	abstract public function setResponse(array $response);
	
	
	/**
	 * Get response data
	 *
	 * @return array $response
	 */
	public function getResponse()
	{
		return Session::instance()->get('auth');
	}

	
	/**
	 * Get token object	
	 *
	 * @return AccessToken $token
	 */
	public function getToken()
	{
		$hammer_auth = Session::instance()->get('hammer_auth');
		return $hammer_auth['access_token'];
	}
	
	/**
	 * Method to prepare incomming params data
	 * to set in on the called class options
	 *
	 * @return static
	 */
	abstract protected function prepareParams( $response );
	
	
	/**
	 * Magick method to set option of called class	
	 *
	 * @param string $key Key of the item to set in option called class
	 * @param mixed $value Mixed value of this key
	 */
	public function __set($key, $value = NULL)
	{
		if( !empty($value) )
		{
			$this->{$key} = $value;	
		}
	}
	
	/**
	 * Magick method to get option of the called class
	 *
	 * @param string $key Key of the item to set in option called class
	 * 
	 * @return mixed return Mixed value of the called option of the class
	 */
	public function __get($key)
	{
		if( isset( $this->{$key} ) )
		{
			return $this->{$key};
		}
	}
	
	
	/**
	 * Magick method to call getter of the option
	 *
	 * @param string $name Name of the called method
	 * @param array $arguments Arguments to past in the called method
	 * 
	 * @return mixed $value Return the value which generated by called magick method
	 */
	 public function __call($name, array $arguments)
	 {
		 
	 }
	 
	 /**
	 * @access private
	 * CLosed method __clone in the singleton	
	 */
	private function __clone(){}
	
	
	/**
	 * @access private
	 * CLosed method __wakeup in the singleton	
	 */
	private function __wakeup(){}
}