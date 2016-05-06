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
    'yandex' => [
        'id' => '3be595ed92b4482da87780cc69638342',
        'secret' => '537749d215894a30be09504a0847cfc9'
    ]
);