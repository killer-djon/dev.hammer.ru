<?php defined('SYSPATH') or die('No direct script access.');

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Provider\Exception\FacebookProviderException;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Psr\Http\Message\ResponseInterface;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;

class Kohana_Provider_Google extends Provider
{
	use BearerAuthorizationTrait;
	
	const ACCESS_TOKEN_RESOURCE_OWNER_ID = 'id';
	
	/**
     * @var string If set, this will be sent to google as the "access_type" parameter.
     * @link https://developers.google.com/accounts/docs/OAuth2WebServer#offline
     */
    protected $accessType;

	
	/**
     * Production Graph API URL.
     *
     * @const string
     */
    const BASE_URL = 'https://accounts.google.com';

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
    const BASE_TOKEN_URL = 'https://www.googleapis.com';
    
    /**
	 * @var string	
	 */
	protected 
		
		$hd = '',
		
		$login_hint = '',
		
		$prompt = '',
		
		$display = '',
		
		$access_type = '';
	
	
    /**
     * Uri to authorize user
     *
     * @var string
     */
    protected $_urlAuthorize = '/o/oauth2/v2/auth';

    /**
     * Access token basre url
     *
     * @var string
     */
    protected $_urlAccessToken = '/oauth2/v4/token';

    /**
     * Personal info uri
     *
     * @var string
     */
    protected $_urlResourceOwnerDetails = 'https://www.googleapis.com/plus/v1/people/me?';

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
    protected $_provider = 'google';

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
        'name(familyName,givenName)',
        'displayName',
        'emails',
        'image'
    ];

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
        $params = array_merge(
            parent::getAuthorizationParameters($options),
            $this->_config
        );
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
        return [
        	'openid',
        	'email'
        ];
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
        $fields = $this->getFields();
        return $this->_urlResourceOwnerDetails . http_build_query([
            'fields' => implode(",", $fields),
            'alt'    => 'json',
        ]);
    }
    
    
    /**
     * @inheritdoc
     */
    protected function checkResponse(ResponseInterface $response, $data)
    {
        if (!empty($data['error'])) {
            $code  = 0;
            $error = $data['error'];
            if (is_array($error)) {
                $code  = $error['code'];
                $error = $error['message'];
            }
            throw new IdentityProviderException($error, $code, $data);
        }
    }

    /**
     * @inheritdoc
     */
    protected function createResourceOwner(array $response, AccessToken $token)
    {
	    $account = Account_Google::getInstance($response, $token);
	    
	    $this->auth_data = $account->getAuthData();
    }

}