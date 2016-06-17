<?php
namespace AppBundle\Services\Search;

class CategorySearch extends AbstractSearch
{
	
	const CONTENT_SELECTOR = '#result-by-engine';
	/*
	 * URI string of the search engnine
	 *
	 * @const String	CATEGORY_URL
	 */
	const CATEGORY_URL = '/search_motor.html?q_motor={category}&full_motor=no';
	
	/*
	 * URI string of the generic by view
	 *
	 * @const String	CATEGORY_VIEW
	 */
	const CATEGORY_VIEW = '/search_mark_ifr.php';
	
	/*
	 * URI string when get engine by generic
	 *
	 * @const String	GENERIC_URL
	 */
	const GENERIC_URL = '/search_model_ifr.php?mark_id={view_id}';
	
	
	/*
	 * URI string when get all parts by engine
	 *
	 * @const String	ENGINE_URL
	 */
	const ENGINE_URL = '/search_motor_ifr.php?mark_id={view_id}&model_id={generic_id}';
	
	
	/**
	 * Cell key in table
	 * this is array with associative keys
	 *
	 * @var array $cellsKey	
	 */
	private $cellsKey = [
		1	=> 'auto',
		2	=> 'name',
		4	=> 'fluent',
		5	=> 'cilinder',
		6	=> 'clapan_per_cilinder',
		7	=> 'diametr_porshen',
		8	=> 'hod_porshen',
		9	=> 'work_obiem'
	];
	
	/**
	 * @inheritdoc	
	 */
	public function collectData()
	{
		$table = $this->crowler->filter(self::CONTENT_SELECTOR);
		
		$data = [];
		$table->filter('tr')->reduce(function($node, $key) use (&$data){
			$node->filter('td')->reduce(function($cell, $cellKey) use ($key, &$data){
				if( isset($this->cellsKey[$cellKey]) )
				{
					$data[$key][$this->cellsKey[$cellKey]]	= $cell->text();	
				}
			});
		});
		
		if( empty($data) )
		{
			return [];
		}
		
		array_shift($data);
		
		foreach( $data as $key =>& $item )
		{
			$item = array_merge($item, [
				'param'	=> 'parts',
				'date_create'	=> new \MongoDate()
			]);
			
		}
		
		return $data;
	}
}