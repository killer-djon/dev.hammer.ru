<?php defined('SYSPATH') or die('No direct script access.');

class Kohana_Account_Linkedin extends Account
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
			'first_name'	=> $response['firstName'],
			'last_name'	=> $response['lastName'],
			'username'	=> $response['emailAddress'],
			'useremail'	=> $response['emailAddress']
		];
	}
}