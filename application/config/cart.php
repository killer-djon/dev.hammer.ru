<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'session' => array(
		'lifetime'  => Date::DAY,
		'type'      => Session::$default,
		'key'       => 'hammer_shop_cart',
	),
	'model_product' => 'Cart_Product', // ORM adapter for products table

	'emailTo'	=> [
		'fkt@fkt.ru',
		'serg@fkt.ru'	=> 'Сердечкин Сергей',
		'alex@fkt.ru'	=> 'Александр',
		'avtoring_as@mail.ru'	=> 'Александр',
		'kil-djon@yandex.ru'	=> 'Евгений'
	],
	'emailFrom'	=> [
		'info@hammerschmidt.ru'	=> 'Интернет-магазин деталей HAMMERSCHMIDT'
	],
	'emailTemplate'	=> 'email/templatecart'
);