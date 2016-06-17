<?php defined('SYSPATH') or die('No direct script access.');

class Kohana_Account_Google extends Account
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
		$emails = Arr::get($response['emails'], 0);
		
		return [
			'user_id'	=> $response['id'],
			'first_name'	=> $response['name']['givenName'],
			'last_name'	=> $response['name']['familyName'],
			'username'	=> $emails['value'],
			'useremail'	=> $emails['value'],
		];
	}
}