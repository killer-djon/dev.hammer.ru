<?php defined('SYSPATH') or die('No direct script access.');

class Kohana_Account_Instagram extends Account
{
	/**
	 * @inheritdoc	
	 */	
	public function setResponse(array $response)
	{
		$result = $response['data'];
		
		Session::instance()->set('auth', [
			'user'	=> $this->prepareParams($result),
			'token'	=> $this->getToken()
		]);
	}

	
	
	/**
	 * @inheritdoc	
	 */
	protected function prepareParams( $response )
	{	
		$fullname = explode(' ', $response['full_name']);
		
		return [
			'user_id'	=> $response['id'],
			'first_name'	=> $fullname[0],
			'last_name'	=> $fullname[1],
			'username'	=> $response['username'],
			'useremail'	=> $response['username']
		];
	}
}