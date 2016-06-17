<?php defined('SYSPATH') or die('No direct script access.');

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Provider\Exception\FacebookProviderException;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Psr\Http\Message\ResponseInterface;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;

class Kohana_Provider_Linkedin extends Provider
{
	use BearerAuthorizationTrait;

	
	/**
     * Production Graph API URL.
     *
     * @const string
     */
    const BASE_URL = 'https://www.linkedin.com/uas';


    /**
     * Default scopes
     *
     * @var array
     */
    public $defaultScopes = [
	    'r_basicprofile',
	    'r_emailaddress'
    ];
    
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
    const BASE_TOKEN_URL = 'https://www.linkedin.com/uas';
	
    /**
     * Uri to authorize user
     *
     * @var string
     */
    protected $_urlAuthorize = '/oauth2/authorization';

    /**
     * Access token basre url
     *
     * @var string
     */
    protected $_urlAccessToken = '/oauth2/accessToken';

    /**
     * Personal info uri
     *
     * @var string
     */
    protected $_urlResourceOwnerDetails = 'https://api.linkedin.com/v1/people/~:';

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
    protected $_provider = 'linkedin';

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


    protected $_fields = [
        'id', 
	    'email-address', 
	    'first-name', 
	    'last-name', 
	    'headline',
        'location', 
        'industry', 
        'picture-url', 
        'public-profile-url',
    ];

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
        return $this->_urlResourceOwnerDetails . '(' . $fields . ')?' . http_build_query([
	        'format'	=> 'json'
        ]);
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
        
        if (!empty($data['error'])) {
            throw new IdentityProviderException($data['error_description'], $response->getStatusCode(), $response);
        }
    }

    /**
     * @inheritdoc
     */
    protected function createResourceOwner(array $response, AccessToken $token)
    {
	    $account = Account_Linkedin::getInstance($response, $token);
	    
	    $this->auth_data = $account->getAuthData();
    }

}