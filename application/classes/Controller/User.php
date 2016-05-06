<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class to authorize user
 * for many
 */
class Controller_User extends Controller
{

    public function action_index()
    {

    }

    public function action_authorize()
    {
        // Load the provider
        /*$this->provider = OAuth2_Provider::factory($provider);

        // Load provider configuration
        $config = Kohana::$config->load('oauth')->$provider;

        // Load the client for this provider
        $this->client = OAuth2_Client::factory($config);

        if ($token = $this->session->get($this->key('access')))
        {
            // Make the access token available
            $this->token = $token;
        }*/
        $config = Kohana::$config->load('oauth')->as_array();

        print_r( $config );
    }

}