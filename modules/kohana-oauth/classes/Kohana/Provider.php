<?php defined('SYSPATH') or die('No direct script access.');

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Provider\Exception\FacebookProviderException;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Psr\Http\Message\ResponseInterface;

abstract class Kohana_Provider extends AbstractProvider
{
	const AUTH_DATA = 'auth_data';

    protected static $_instance = NULL;

    /**
     * Config options for current provider
     * on the parent class this options is required
     *
     * @var array
     */
    protected $_config = [];

    /**
     * Stirng url to authorize on the server
     *
     * @var string
     */
    protected $requestAuthUrl;


    /**
     * String get accesss_token url
     *
     * @var string
     */
    protected $requestTokenUrl;

    /**
     * Global storage object
     * to store auth data and access token
     *
     * @var Kohana_Session
     */
    protected $_storage;

    private $_storage_key = 'hammer_auth';


    public function getProvider()
    {
        return $this->_provider;
    }

    public function getClassName()
    {
        return static::class;
    }

    public function getConfig()
    {
        return $this->_config;
    }


    /**
     * @inheritdoc
     */
    public function getAccessTokenUrl(array $params)
    {
        return parent::getAccessTokenUrl($params);
    }


    /**
     * @inheritdoc
     */
    public function __construct(array $options = [], array $collaborators = [])
    {
        $this->_config = Kohana::$config->load('oauth')->get($this->_provider);

        //$this->_config['redirectUri'] = $this->getRedirectUri();
        $this->_config = array_merge($options, $this->_config);

        $this->_storage = Session::instance();
        $this->_collaborators = $collaborators;

        parent::__construct($this->_config, $this->_collaborators);

    }

    public function getStorage()
    {
        return $this->_storage;
    }

    public function removeStorageKey($key)
    {
        $data = $this->getStorageKey($key);
        if( !is_null($data) )
        {
            $this->_storage->delete( $this->_storage_key );
        }
    }

    public function getStorageKey($key)
    {
        return (!isset($this->_storage->get($this->_storage_key)[$key]) ? NULL : $this->_storage->get($this->_storage_key)[$key]);
    }

    public function setStorageKey($key, $value)
    {
        $content = $this->_storage->get($this->_storage_key);

        $this->_storage->set(
            $this->_storage_key,
            ( is_array($content) ? array_merge( $content, [$key    => $value] ) : [$key    => $value] )
        );

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getResourceOwner(AccessToken $token)
    {
        $resourceOwner = parent::getResourceOwner($token);
        $this->setStorageKey(self::AUTH_DATA, $resourceOwner);

        return $this;
    }

    /**
     * Set required redirect uri
     * to redirect on auth complete
     *
     * @param string $uri String uri to redirect, must be valid uri
     */
    abstract public function setRedirectUri($uri = NULL);

    /**
     * Get required redirect uri
     * but will magic release for this
     *
     * @return mixed redirectUri
     */
    abstract public function getRedirectUri();


    /**
     * @inheritdoc
     */
    public function getBaseAuthorizationUrl()
    {
        return static::BASE_URL.static::BASE_API_VERSION.$this->_urlAuthorize;
    }

    /**
     * @inheritdoc
     */
    public function getBaseAccessTokenUrl(array $params)
    {
        return static::BASE_TOKEN_URL.static::BASE_API_VERSION.$this->_urlAccessToken;
    }


    /**
     * @inheritdoc
     */
    protected function checkResponse(ResponseInterface $response, $data)
    {
        if (!empty($data['error'])) {
            $message = $data['error']['type'].': '.$data['error']['message'];
            throw new IdentityProviderException($message, $data['error']['code'], $data);
        }
    }
    
    public function createResourceOwner(array $response, AccessToken $token)
    {
	    return $response;
    }
    
    /**
     * @inheritdoc
     */
    protected function getScopeSeparator()
    {
        return ',';
    }


}