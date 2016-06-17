<?php
namespace AppBundle\Services\Search;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
	
abstract class AbstractSearch implements SearchInterface
{
	/*
	 * Proxy address local
	 * this address will mask our connection
	 *
	 * @const String	
	 */
	const PROXY_ADDRESS = '127.0.0.1:';
	
	
	/*
	 * Proxy port
	 * port for proxy address
	 *
	 * @const String	
	 */
	const PROXY_PORT = '9050';
	
	/**
	 * Remote uri page
	 *
	 * @const string $uri
	 */
	const REMOTE_URI = 'http://www.motoristam.ru';
	
	
	protected $crowler;
	
	/**
	 * Get content from remote source
	 * will be return html content
	 *
	 * @param string $name Name of the searching data
	 */
	public function search($name)
	{
		$uri = $this->_prepareUri( static::CATEGORY_URL, ['category'	=> $name]);
		$body = $this->getRemotePage( $uri );
		
		$this->crowler = new Crawler($body);
		return $this;
	}
	
	/**
	 * Get content from remote source
	 * will be return html content
	 *
	 * @return HTMLDom $html
	 */
	private function getRemotePage( $uri )
	{
		$client = new Client(['base_uri' => static::REMOTE_URI]);
		$request = $client->request('GET', $uri, [
			'curl' => [
		        CURLOPT_PROXY	=> self::PROXY_ADDRESS.self::PROXY_PORT,
		        CURLOPT_PROXYTYPE	=> CURLPROXY_SOCKS5,
		        CURLOPT_FOLLOWLOCATION => TRUE,
				CURLOPT_RETURNTRANSFER => TRUE,
		    ]
		]);
		
		return $request->getBody()->getContents();
	}
	
	/**
	 * prepare url string to correct format
	 *
	 * @param string $uri String url with placeholders
	 * @param array $params Params to replace in the placeholder
	 * @return string $uri 
	 */
	private function _prepareUri($uri, array $param = [])
	{
		if( !empty( $param ) )
		{
			$params = array_map(function($itemKey){
				return '/{'.$itemKey.'}/';
			}, array_keys($param));
			
			$replaceHolder = array_combine($params, $param);
			$url = preg_replace($params, $param, $uri);
			
		}else
		{
			$url = $uri;
		}
		
		return $url;
	}
	
	/**
	 * Collector of the html data
	 * in the returned content
	 *
	 * return array $data Return collected data
	 */
	abstract public function collectData();
}