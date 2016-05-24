<?php
namespace AppBundle\Services\Search;

class CategorySearch extends AbstractSearch
{
	
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
	 * @inheritdoc	
	 */
	public function collectData()
	{
		$table = $this->crowler->filter('#result-by-engine')->html();
	}
}