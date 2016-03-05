<?php defined('SYSPATH') OR die('No direct access allowed.');

return array
(
	'default' => array(
		'type' => 'MongoDB',
		//'server' => 'mongodb://localhost:27017',
		//'database' => 'dev_hammer_v3',
		'hostname'	=> 'localhost',
		'port'	=> 27017,
		
		'options'	=> array(
			'auth'	=> TRUE,
			'authMechanism'	=> 'SCRAM-SHA-1',
			'username'	=> 'hammer',
			'password'	=> 'nyFFqv2015',
			'db'	=> 'dev_hammer_v3'
		)
	),
);
