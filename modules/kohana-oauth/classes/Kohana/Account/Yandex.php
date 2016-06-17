<?php defined('SYSPATH') or die('No direct script access.');

class Kohana_Account_Yandex extends Account
{

	/**
	 * @inheritdoc	
	 */	
	public function setResponse(array $response)
	{
		
		Session::instance()->set('auth', [
			'user'	=> $this->prepareParams($response),
			'token'	=> $this->getToken()
		]);
	}

	
	
	/**
	 * @inheritdoc	
	 */
	protected function prepareParams( $response )
	{	
		return [
			'user_id'	=> $response['id'],
			'first_name'	=> $response['first_name'],
			'last_name'	=> $response['last_name'],
			'username'	=> $response['display_name'],
			'useremail'	=> $response['default_email']
		];
	}
	
}