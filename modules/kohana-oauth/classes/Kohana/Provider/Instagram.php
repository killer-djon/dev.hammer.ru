<?php defined('SYSPATH') or die('No direct script access.');

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Provider\Exception\InstagramIdentityProviderException;
use Psr\Http\Message\ResponseInterface;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;

class Kohana_Provider_Instagram extends Provider
{
	const ACCESS_TOKEN_RESOURCE_OWNER_ID = 'user.id';

	
	/**
     * Production Graph API URL.
     *
     * @const string
     */
    const BASE_URL = 'https://api.instagram.com';


    /**
     * Default scopes
     *
     * @var array
     */
    public $defaultScopes = ['basic', 'public_content'];
    
    /**
     * Version api
     *
     * @const string
     */
    const BASE_API_VERSION = '';

    /**
     * Graph URL for facebook only
     *
     * @const string
     */
    const BASE_TOKEN_URL = 'https://api.instagram.com';
	
    /**
     * Uri to authorize user
     *
     * @var string
     */
    protected $_urlAuthorize = '/oauth/authorize';

    /**
     * Access token basre url
     *
     * @var string
     */
    protected $_urlAccessToken = '/oauth/access_token';

    /**
     * Personal info uri
     *
     * @var string
     */
    protected $_urlResourceOwnerDetails = 'https://api.instagram.com/v1/users/self?';

    /**
     * Auth code string
     *
     * @const string
     */
    const AUTHORIZATION_CODE = 'authorization_code';

    /**
     * Provider name, need for identicate
     * current provider
     * @required option
     *
     * @var string
     */
    protected $_provider = 'instagram';

    /**
     * Redirect uri to get the access_token
     * when we have code from auth first step
     * @required option
     *
     * @var string
     */
    protected $_redirectUriToken = 'user/login/';

    

    /**
     * Redirect uri when get user info
     * @required option
     *
     * @var string
     */
    //protected $_redirectUri;


    protected $_fields = [];

	/**
     * @inheritdoc
     */
    protected function getAuthorizationParameters(array $options)
    {	     
        $params = parent::getAuthorizationParameters($options);
        
        if( isset($params['approval_prompt']) )
        {
	        unset($params['approval_prompt']);
        }
        
        return $params;
    }

    public function getFields()
    {
        return $this->_fields;
    }

    /**
     * @inheritdoc
     */
    public function setRedirectUri($uri = null)
    {
        $this->redirectUri = $uri;
    }

    /**
     * @inheritdoc
     */
    public function getRedirectUri()
    {
        return $this->redirectUri;
    }

    /**
     * Get the default scopes used by this provider.
     *
     * This should not be a complete list of all scopes, but the minimum
     * required for the provider user interface!
     *
     * @return array
     */
    protected function getDefaultScopes()
    {
        return $this->defaultScopes;
    }
    
    /**
     * @inheritdoc
     */
    protected function getScopeSeparator()
    {
        return ' ';
    }

    /**
     * @inheritdoc
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        $fields = implode(',', $this->getFields());
        return $this->_urlResourceOwnerDetails.'access_token='.$token;
    }
    /*
    https://api.linkedin.com/v1/people/~:(id,email-address,first-name,last-name,headline,location,industry,picture-url,public-profile-url)?format=json
    https://api.linkedin.com/v1/people/~:(' . $fields . ')?format=json
    */
    /**
     * @inheritdoc
     */
    protected function checkResponse(ResponseInterface $response, $data)
    {
        
        // Standard error response format
        if (!empty($data['meta']['error_type'])) {
            throw InstagramIdentityProviderException::clientException($response, $data);
        }
        
        // OAuthException error response format
        if (!empty($data['error_type'])) {
            throw InstagramIdentityProviderException::oauthException($response, $data);
        }
    }

    /**
     * @inheritdoc
     */
    protected function createResourceOwner(array $response, AccessToken $token)
    {
	    $account = Account_Instagram::getInstance($response, $token);
	    
	    $this->auth_data = $account->getAuthData();
    }

}