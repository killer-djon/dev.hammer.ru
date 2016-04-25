<?php defined('SYSPATH') or die('No direct script access.');


class Controller_Tests extends Controller
{

    const AUTO_YANDEX_RSS = 'https://news.yandex.ru/auto.rss';

    public function action_index()
    {
        $rssFeed = Feed::loadRss( self::AUTO_YANDEX_RSS );
        
        echo '<pre>';
        print_r( $rssFeed );
    }
}