<?php defined('SYSPATH') or die('No direct script access.');

use League\OAuth2\Client\Token\AccessToken;

class Kohana_Account_Vk extends Account
{

	/**
	 * @inheritdoc	
	 */	
	public function setResponse(array $response)
	{
		$result = Arr::get($response['response'], 0);
		
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
		$token = $this->getToken();
		
		if( $token instanceof AccessToken )
		{
			$tokenValue = $token->getValues()['email'];

		}else
		{
			if( is_array( $token ) )
			{
				$tokenValue = $token['email'];
			}else
			{
				$tokenValue = $token;
			}
		}
		
		
		return [
			'user_id'	=> $response['uid'],
			'first_name'	=> $response['first_name'],
			'last_name'	=> $response['last_name'],
			'username'	=> $response['nickname'],
			'useremail'	=> $tokenValue
		];
	}
	
}