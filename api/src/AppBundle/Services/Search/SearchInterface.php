<?php
namespace AppBundle\Services\Search;

interface SearchInterface
{
	/**
	 * Collect data from html content
	 * getted from remote source
	 *
	 * @return array of the finded data
	 */
	public function collectData();
	
	/**
	 * Do search action in the html content
	 *
	 * @param String $name	Name of the searging arguments
	 */
	public function search($name);
}