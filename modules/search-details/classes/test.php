<?php defined('SYSPATH') OR die('No direct script access.');
namespace modules\components;

use modules\components\request\Request_Client_Curl;
use modules\components\request\Request;
/**
 * Класс реализующий поиск информации
 * с указанного ресурса
 * указание ресурса происходит в наследующих классах
 *
 * Поиск происходит через прокси, чтобы не DDoS-ить ресурс
 *
 * @package Search
 * @author Leshanu E <kil-djon@yandex.ru>
 */
abstract class Search implements \ArrayAccess
{
    /*
     * Proxy address local
     * this address will mask our connection
     *
     * @const String
     */
    const PROXY_ADDRESS = '127.0.0.1';


    /*
     * Proxy port
     * port for proxy address
     *
     * @const String
     */
    const PROXY_PORT = '9050';

    /*
     * Collecting data from remote page
     * this data will contains array of data
     *
     * @const Array
     */
    protected $_data = array();


    /*
     * Check if data is refreshed after call method
     * refreshData
     *
     * @var boolean
     */
    protected $_isRefreshing = false;


    /**
     * Абстрактный метод поиска данных
     * должен быть реализован во всех наследниках
     *
     * @param string $name Элемент поиска
     */
    abstract function searchData($name);

    /**
     * Проверка искомого элемента
     * в уже имеющемся наборе данных
     * если его нету сначит идем и ищем его в ресурсе
     *
     * @param string $name Элемент поиска
     */
    abstract function findData($name);


    /*
     * Получаем текущее значение набора данных
     *
     * @return mixed $_current
     */
    public function getCurrent()
    {
        return $this->_current;
    }

    /*
     * Устанавливаем текущее значение набора данных
     *
     * @param mixed $data - Текущее значение искомой строки
     * @return void
     */
    public function setCurrent($data = NULL)
    {
        $this->_current = $data;
    }


    /*
     * Remote search page by URL
     * if needed then type encoding for remote page to get
     * this method will return HTML page
     *
     * @param string $url Remote address from where will be get the page content
     * @param string $encoding Past the encoding to get from this
     *
     * @return String/NULL - Return remote html page or null if not is finds
     */
    public function searchPage( $url = '', $toEncoding = 'UTF-8', $fromEncoding = 'CP1251')
    {
        if( !empty( $url ) )
        {
            $client = Request_Client_Curl::factory();
            $client->options(array(
                CURLOPT_URL	=> trim($url),
                CURLOPT_PROXY	=> self::PROXY_ADDRESS.':'.self::PROXY_PORT,
                CURLOPT_PROXYTYPE	=> CURLPROXY_SOCKS5,
                CURLOPT_FOLLOWLOCATION => TRUE,
                CURLOPT_RETURNTRANSFER => TRUE,
            ));

            $request = Request::factory();
            $request->client($client);

            $response = $request->execute();

            return iconv($fromEncoding, $toEncoding."//IGNORE", $response->body());
        }

        return NULL;
    }


    /*
     * Create row for search index
     * on the collection search
     * this collection will contains all search indexes
     * on first time we must check this index
     * and if not find then do search
     * else create them
     *
     * @param String $collection - String collection name when must search
     * @param String $field - String field name for search
     * @param String $value - Value for this searched field
     *
     * @return void - Nothing, only create index
     */
    public function createSearchIndex($collection, $field, $param = 'search', $value = NULL, $requestUri = NULL)
    {
        if( empty( $collection ) )
        {
            throw new Kohana_Exception("Collection name can't be empty");
        }

        if( empty( $field ) )
        {
            throw new Kohana_Exception("Field name can't be empty");
        }

        $request = (!is_null($requestUri) ? $requestUri : Request::detect_uri());

        $model = MongoModel::factory('SearchIndex');
        $model->selectDB();

        $searchRow = $model
            ->where('collection', '=', $collection)
            ->where('field', '=', $field)
            ->where('value', '=', $value)
            ->where('search_page', '=', $request)
            ->find();

        if( $searchRow->loaded() )
        {
            // then row will be finded and must be update
            $searchRow->inc('search_count');
            $searchRow->set('last_search', new MongoDate());
            $searchRow->set('search_page', $request);
            $searchRow->save();

            $searchRow->clear();
        }else
        {
            $model->values(array(
                'collection'	=> $collection,
                'field'			=> $field,
                'value'			=> $value,
                'type'			=> $param,
                'search_count'	=> 1,
                'first_search'	=> new MongoDate(),
                'search_page'	=> $request
            ));
            $model->save();
            $searchRow->clear();
        }

        return $this;
    }


    /*
     * Get main container form HTML string
     * this is basic container with all needed data
     *
     * @param String $selector - The basic container selector
     *
     * @return Object simple_html_dom_node - Get the basic container wich contains all data
     */
    public function getContainer( $selector )
    {

    }


    public function clearOffsets()
    {
        $this->_data = array();
    }


    public function offsetExists( $offset )
    {

        return isset($this->_data[$offset]);

    }


    public function offsetUnset( $offset )
    {
        if( $this->offsetExists( $offset) )
        {
            unset($this->_data[$offset]);
        }
    }


    public function offsetSet( $offset, $value )
    {
        if( !$this->offsetExists($offset) )
        {
            $this->_data[$offset] = $value;
        }
    }


    public function offsetSets( array $offsets )
    {
        $this->clearOffsets();
        foreach( $offsets as $key => $offset )
        {
            $this->offsetSet($key, $offset);
        }
    }


    public function offsetGet( $offset )
    {
        if( $this->offsetExists($offset) )
        {
            return $this->_data[$offset];
        }

        return NULL;
    }

    public function offsetSize()
    {
        return sizeof($this->_data);
    }


    public function getOffsets()
    {
        return $this->_data;
    }



    /*
     * Get all our cross products
     *
     * This method must return all cross
     * products after we call search or load
     * another product data from system
     *
     * @return array Return array of finded data
     */
    public function collectCrossProducts($column_name = 'article')
    {
        $responseData = [];

        if( $this->offsetSize() > 0 )
        {
            $keys = [];

            $keys = array_map(function($element) use($column_name)
            {
                return $element[$column_name];
            }, $this->getOffsets());

            $model = MongoModel::factory('CrossProducts');
            $model->selectDB();

            $rows = $model
                ->where('cross_article', 'in', array_unique($keys))
                ->sort('article')
                ->find_all();
            $data = [];

            /**
             * Refactoring code
             * this values return with group at crosses articles
             */

            if( is_array($rows) && count($rows) )
            {
                foreach( $rows as $key => $item )
                {
                    foreach( $keys as $arKey )
                    {
                        if( in_array($arKey, $item['cross_article']) )
                        {
                            $data[$arKey][] = $item;
                        }
                    }
                }
            }

            $responseData = $data;
        }

        return $responseData;
    }


    /*
     * Refresh data by key
     *
     * This method will refresh  multidimensional array
     * by input key, becouse we can return from db/search
     * array with multiple identical data
     *
     * @param string $keyArr string of the key to put in new array
     *
     * @return self
     */
    public function refreshData($keyArr = null)
    {
        if( $this->offsetSize() > 0 )
        {
            $_data = array();
            $offsets = $this->getOffsets();

            foreacH( $offsets as $key => $item )
            {
                $_data[ ( !is_null($keyArr)?$item[$keyArr]:$key ) ] = $item;
            }

            if( !empty( $_data ) )
            {
                $this->clearOffsets();
                $i = 0;
                foreach( $_data as $key => $item )
                {
                    $this->offsetSet( $i, $item );
                    $i++;
                }

                if( $this->offsetSize() > 0 )
                {
                    $this->_isRefreshing = true;
                }
            }
        }

        return $this;
    }


    public function isRefreshing()
    {
        return (bool)$this->_isRefreshing;
    }


    public function setLastStep($values = array())
    {
        $model = MongoModel::factory('LastStep');
        $model->selectDB();

        if( !empty($values) )
        {
            $model->remove_all();
            $model->values($values);
            $model->save();
        }

        return $this;
    }

    public function getLastStep()
    {
        $model = MongoModel::factory('LastStep');
        $model->selectDB();

        return $model->find()->lastDocument();
    }

    /**
     * Make price items like (qty, price)
     * on the products array
     *
     * @param array $rows Reference of the products rows
     * @return void
     */
    public function makePrice(array & $rows)
    {
        if( empty($rows) )
            return;

        $articles = array_column($rows, 'article');

        $articles = array_map(function($item){
            settype($item, 'string');
            return $item;
        }, $articles);

        $model = MongoModel::factory('Prices');
        $model->selectDB();

        $priceRows = $model
            ->where('article', 'in', $articles)
            ->find_all();

        if( empty($priceRows) )
        {
            foreach( $rows as $key =>& $item )
            {
                $item['qty'] = 0;
                $item['price'] = 0;
            }

            return $rows;
        }


        $priceRows = array_combine(array_column($priceRows, 'article'), $priceRows);

        foreach( $rows as $key =>& $item )
        {
            $item['qty'] = ( isset($priceRows[$item['article']]['qty']) ? $priceRows[$item['article']]['qty'] : 0 );
            $item['price'] = ( isset($priceRows[$item['article']]['price']) ? $priceRows[$item['article']]['price'] : 0 );
        }
        return $rows;

    }
}