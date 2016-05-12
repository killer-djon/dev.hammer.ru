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
    
    public function action_index()
    {
	    echo $this->request->uri();
    }
    
    
    /**
     * This method must initialize the OAuth_Client library
     * and do something from them
     *
     */
    public function before()
    {
	    echo '<pre>';
	    $this->provider = $this->request->param('provider');
	    
	    $this->code = $this->request->query('code');

	    if( !empty( $this->provider ) )
	    {
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
		print_r( $this->client );
	}
}