<?php defined('SYSPATH') or die('No direct script access.');

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Psr\Http\Message\ResponseInterface;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;

class Kohana_Provider_Dropbox extends Provider
{
	/**
     * @var string Key used in the access token response to identify the resource owner.
     */
    const ACCESS_TOKEN_RESOURCE_OWNER_ID = 'uid';
	

	
	/**
     * Production Graph API URL.
     *
     * @const string
     */
    const BASE_URL = 'https://www.dropbox.com/1';

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
    const BASE_TOKEN_URL = 'https://www.dropbox.com/1';

    /**
     * Uri to authorize user
     *
     * @var string
     */
    protected $_urlAuthorize = '/oauth2/authorize';

    /**
     * Access token basre url
     *
     * @var string
     */
    protected $_urlAccessToken = '/oauth2/token';

    /**
     * Personal info uri
     *
     * @var string
     */
    protected $_urlResourceOwnerDetails = 'https://api.dropbox.com/1/account/info?';

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
    protected $_provider = 'dropbox';

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

    /*
    'clientId'                => 'demoapp',    // The client ID assigned to you by the provider
    'clientSecret'            => 'demopass',   // The client password assigned to you by the provider
    'redirectUri'             => 'http://example.com/your-redirect-url/',
    'urlAuthorize'            => 'http://brentertainment.com/oauth2/lockdin/authorize',
    'urlAccessToken'          => 'http://brentertainment.com/oauth2/lockdin/token',
    'urlResourceOwnerDetails' => 'http://brentertainment.com/oauth2/lockdin/resource'
    */


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
     * @inheritdoc
     */
    public function getDefaultScopes()
    {
        return [];
    }


    /**
     * @inheritdoc
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        $fields = $this->getFields();
        return $this->_urlResourceOwnerDetails . 'access_token='.$token;
    }
    
    
    /**
     * @inheritdoc
     */
    protected function checkResponse(ResponseInterface $response, $data)
    {
        if (isset($data['error'])) {
            throw new IdentityProviderException(
                $data['error'] ?: $response->getReasonPhrase(),
                $response->getStatusCode(),
                $response
            );
        }
    }

    /**
     * @inheritdoc
     */
    public function createResourceOwner(array $response, AccessToken $token)
    {
	    return $response;
        //Account_Dropbox::getInstance( $response, $token );
    }

}