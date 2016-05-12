<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Configuration for OAuth providers.
 */
return array(
    /**
     * Twitter applications can be registered at https://twitter.com/apps.
     * You will be given a "consumer key" and "consumer secret", which must
     * be provided when making OAuth requests.
     */
    // 'twitter' => array(
    // 	'key' => 'your consumer key',
    // 	'secret' => 'your consumer secret'
    // ),
    /**
     * Github applications can be registered at https://github.com/account/applications/new.
     * You will be given a "client id" and "client secret", which must
     * be provided when making OAuth2 requests.
     */
    // 'github' => array(
    // 	'id' => 'your client id',
    // 	'secret' => 'your client secret'
    // ),

    /**
     * @https://github.com/settings/developers
     * this is url when we can edit develop project
     */
    'github' => [
        'id' => '43cc72228de49c14d51c',
        'secret' => '775e24941654e4db11b57c0e05408895fd81ed62'
    ],
    /**
     * @https://oauth.yandex.ru/
     * this is url when we can edit develop project
     */
    'vk'	=> [
	    'clientId'	=> '5453046',
	    'clientSecret'	=> 'ftTxMgp07SgyQikyocfN'
    ],
    'google'	=> [
	    'clientId'	=> '96332511459-bsjnc4h45dr4sr88i0hl3kc7hcmd720m.apps.googleusercontent.com',
	    'clientSecret'	=> '_-xOn3EZQNPxq_jvYulsGAPo',
	    'login_hint'	=> 'sub',
	    'prompt'	=> 'select_account',
	    'display'	=> 'popup'
    ],
    /**
     * @https://apps.twitter.com/app/
     * this is url when we can edit develop project
     */
    'twitter'	=> [
	    'id'	=> 'nEvWeBkrdUrhsiovVnTaCUFl6',
	    'secret'	=> 'bJojViHgSa0PlCYLmM6YmibFeSj5rxWZApRUYx35UnqwlnkCfW',
    ],
    'facebook'	=> [
	    'clientId'	=> '261669577518915',
	    'clientSecret'	=> '3cdd30357040b97d0dc9cf07d3c6288f'
    ]
);