<?php defined('SYSPATH') or die('No direct script access.');

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Provider\Exception\FacebookProviderException;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Psr\Http\Message\ResponseInterface;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;

class Kohana_Provider_Vk extends Provider
{
    /**
     * Production Graph API URL.
     *
     * @const string
     */
    const BASE_URL = 'http://oauth.vk.com';

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
    const BASE_TOKEN_URL = 'https://api.vk.com/oauth';

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
    protected $_provider = 'vk';

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
    protected $_urlAuthorize = '/authorize';

    /**
     * Access token basre url
     *
     * @var string
     */
    protected $_urlAccessToken = '/access_token';

    /**
     * Personal info uri
     *
     * @var string
     */
    protected $_urlResourceOwnerDetails = 'https://api.vk.com/method/users.get?';

    /**
     * Redirect uri when get user info
     * @required option
     *
     * @var string
     */
    //protected $_redirectUri;


    protected $_fields = [
        'email',
        'nickname',
        'screen_name',
        'sex',
        'bdate',
        'city',
        'country',
        'timezone',
        'photo_50',
        'photo_100',
        'photo_200_orig',
        'has_mobile',
        'contacts',
        'education',
        'online',
        'counters',
        'relation',
        'last_seen',
        'status',
        'can_write_private_message',
        'can_see_all_posts',
        'can_see_audio',
        'can_post',
        'universities',
        'schools',
        'verified'
    ];


    public function getFields()
    {
        return $this->_fields;
    }

    /**
     * @inheritdoc
     */
    public function setRedirectUri($uri = null)
    {
        $this->redirectUri = urldecode($uri);
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
        return ['email'];
    }
    
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

    /**
     * @inheritdoc
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        $fields = $this->getFields();

        $url = $this->_urlResourceOwnerDetails . http_build_query([
            'uids'   => $token->user_id,
            'fields' => implode(',', $fields),
            'access_token'    => $token->getToken()
        ]);

        return $url;
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
                $code  = $error['error_code'];
                $error = $error['error_msg'];
            }
            throw new IdentityProviderException($error, $code, $data);
        }
    }

    /**
     * @inheritdoc
     */
    public function createResourceOwner(array $response, AccessToken $token)
    {
        if( isset($response['response']) && count($response['response']) )
        {
	        return $response['response'];
            //Account_Vk::getInstance( array_values($response['response']), $token );
        }
    }
    

}
