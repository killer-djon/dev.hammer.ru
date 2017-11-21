<?php defined('SYSPATH') or die('No direct script access.');

if( !Route::cache() )
{
    Route::set('articles', 'api/v<version>/<format>(/<item_per_page>(/<page>))/<controller>(/<action>(/<id>))',
		array(
			'version' => '[\d+]',
			'format'  => '(json|xml|csv|html)',
			'id'	=> '.*',
			'item_per_page'	=> '[\d]+',
			'page'	=> '[\d]+'
		))
		->defaults(array(
			'format' => 'json',
			'directory'	=> 'api'
		));

    if( Kohana::$caching === TRUE )
    {
        Route::cache(TRUE);
    }
}