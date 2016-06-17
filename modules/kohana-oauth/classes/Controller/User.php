<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class to authorize user
 * for many
 */
class Controller_User extends Controller
{
	/**
     * @var  Kohana_Session Session storage object
     */
	protected $storage;
	
	/**
     * @var  object  OAuth2_Provider
     */
    protected $provider;

    
    /**
     * @var  object  OAuth2_Client
     */
    protected $client = NULL;
    
    protected $accessToken;

    
    /**
     * This method must initialize the OAuth_Client library
     * and do something from them
     *
     */
    public function before()
    {
	    $this->provider = $this->request->param('provider');
	    
	    $this->code = $this->request->query('code');

	    if( !empty( $this->provider ) )
	    {
		    $backUrl = $this->request->query('backUrl');
		    if( empty( $backUrl ) )
		    {
			    throw new Request_Exception('Not is set backURL in the request type', NULL, 400);
		    }
		    
		    $type = 'Provider_'.ucfirst(strtolower($this->provider));
		    $this->client = new $type;
	    }
    }
    
    public function action_authorize()
    {
		if( $this->client )
		{
			$redirectURI = URL::site('user/access/'.$this->provider, TRUE);
			$this->client->setRedirectUri( $redirectURI );
	
			$this->client->removeStorageKey('access_token');
	
			if( empty($this->code) )
			{
				$this->client->clearStorage();
				HTTP::redirect($this->client->getAuthorizationUrl());
			}
		}
		
    }
    
    public function action_access()
    {
		$token = $this->client->getStorageKey('access_token');
		$providerClass = $this->client->getClassName();

		if( !empty($this->code) && is_null( $token ) )
		{
			$redirectURI = URL::site('user/access/'.$this->provider, TRUE);
			$this->client->setRedirectUri( $redirectURI );
			
			$this->accessToken = $this->client->getAccessToken($providerClass::AUTHORIZATION_CODE, [
				'code' => $this->code
			]);

			$this->client->getResourceOwner($this->accessToken);
			$this->client->setStorageKey('access_token', $this->accessToken);
			HTTP::redirect(URL::site('user/access/'.$this->provider, TRUE));
		}

		$this->client->getResourceOwner($token);
		HTTP::redirect( URL::site('user/login/'.$this->provider, TRUE) );
    }

	public function action_login()
	{
		echo '<pre>';
		print_r( $this->client->getAuthData() );
		
	}

	public function action_auth()
	{
		echo '<pre>';
		print_r( $this->request->post() );
		exit;
	}
}