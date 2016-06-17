<?php defined('SYSPATH') or die('No direct access allowed.');

return array(
	Kohana::DEVELOPMENT => array
	(
		'default' => array(
			'driver'     => 'smtp',
			'hostname'   => 'smtp.yandex.ru',
			'username'   => 'info@hammerschmidt.ru',
			'password'   => 'qeeDtDe6'
		),
		'sendmail'	=> [
			'driver'	=> 'sendmail'
		]
	),
	Kohana::PRODUCTION  => array
	(
		'default' => array(
			'driver'     => 'smtp',
			'hostname'   => 'smtp.yandex.ru',
			'username'   => 'info@hammerschmidt.ru',
			'password'   => 'qeeDtDe6'
		),
		'sendmail'	=> [
			'driver'	=> 'sendmail',
		]
	),
);
