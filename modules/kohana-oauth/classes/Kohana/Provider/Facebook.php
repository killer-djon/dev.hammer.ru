<?php defined('SYSPATH') or die('No direct script access.');

use League\OAuth2\Client\Token\AccessToken;

class Kohana_Provider_Facebook extends Provider
{
    /**
     * Production Graph API URL.
     *
     * @const string
     */
    const BASE_URL = 'https://www.facebook.com';

    /**
     * Version api
     *
     * @const string
     */
    const BASE_API_VERSION = '/v2.6';

    /**
     * Graph URL for facebook only
     *
     * @const string
     */
    const BASE_TOKEN_URL = 'https://graph.facebook.com';

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
    protected $_provider = 'facebook';

    /**
     * Redirect uri to get the access_token
     * when we have code from auth first step
     * @required option
     *
     * @var string
     */
    protected $_redirectUriToken = 'user/login/';

    /**
     * Uri to authorize user
     *
     * @var string
     */
    protected $_urlAuthorize = '/dialog/oauth';

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
    protected $_urlResourceOwnerDetails = '/me?';

    /**
     * Redirect uri when get user info
     * @required option
     *
     * @var string
     */
    //protected $_redirectUri;


    protected $_fields = [
        'id',
        'name',
        'first_name',
        'last_name',
        'email',
        'hometown',
        'bio',
        'picture.type(large){url,is_silhouette}',
        'cover{source}',
        'gender',
        'locale',
        'link',
        'timezone'
    ];

    /*
    'clientId'                => 'demoapp',    // The client ID assigned to you by the provider
    'clientSecret'            => 'demopass',   // The client password assigned to you by the provider
    'redirectUri'             => 'http://example.com/your-redirect-url/',
    'urlAuthorize'            => 'http://brentertainment.com/oauth2/lockdin/authorize',
    'urlAccessToken'          => 'http://brentertainment.com/oauth2/lockdin/token',
    'urlResourceOwnerDetails' => 'http://brentertainment.com/oauth2/lockdin/resource'
    */



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
        return ['public_profile', 'email'];
    }

    /**
     * @inheritdoc
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        $fields = $this->getFields();
        return static::BASE_TOKEN_URL.static::BASE_API_VERSION.$this->_urlResourceOwnerDetails . http_build_query([
            'fields' => implode(',', $fields),
            'access_token'    => $token->getToken(),
            'appsecret_proof'   => SecretProof::create($this->clientSecret, $token->getToken())
        ]);
    }

    /**
     * @inheritdoc
     */
    protected function createResourceOwner(array $response, AccessToken $token)
    {
	    $account = Account_Facebook::getInstance($response, $token);
	    
	    $this->auth_data = $account->getAuthData();
    }

}
