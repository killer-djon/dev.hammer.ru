<?php defined('SYSPATH') or die('No direct script access.');

// Autoloading for PHPExcel
require Kohana::find_file('vendor', 'autoload');

if( !Route::cache() )
{
    Route::set('user', 'user(/<action>(/<provider>))', [
        'provider'  => '([a-zA-Z_\-\.]+)'
    ])
    ->defaults(array(
        'controller' => 'user',
        'action' => 'index',
    ));

    if( Kohana::$caching === TRUE )
    {
        Route::cache(TRUE);
    }
}