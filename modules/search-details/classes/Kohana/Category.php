<?php defined('SYSPATH') OR die('No direct script access.');
/**
 *
 * @package Search
 */
 
class Kohana_Category extends Kohana_Search 
{
	const CATEGORY_URL = 'http://www.motoristam.ru/search_motor.html?q_motor={category}&full_motor=no';
	
	const CATEGORY_VIEW = 'http://www.motoristam.ru/search_mark_ifr.php';
	
	const GENERIC_URL = 'http://www.motoristam.ru/search_model_ifr.php?mark_id={view_id}';
	
	const ENGINE_URL = 'http://www.motoristam.ru/search_motor_ifr.php?mark_id={view_id}&model_id={generic_id}';
	
	const PARTS_URL = 'http://www.motoristam.ru/';
	
	private static $_instance = NULL;
	
	
	
	public static function getInstance()
	{
		if( is_null( self::$_instance ) )
		{
			self::$_instance = new self();
		}
		
		return self::$_instance;
	}
	
	
	/*
	 * Set metadata from last step of the cursive per categories
	 * this is need to get last row for parentId
	 *
	 * @param mixed $values - Values to update at field metadata can be mixed
	 *
	 * @return self	
	 */
	public function setMetaData($values = NULL)
	{
		if( !is_null($values) )
		{
			$model = MongoModel::factory('LastStep');
			$model->selectDB();
			
			$row = $model->find();
			if( $row->loaded() )
			{
				if( isset($values['_id']) )
				{
					$values['id'] = $values['_id']['$id'];
					unset($values['_id']);
				}
				
				$row->set('metadata', $values);
				$row->save();
			}
		}
		
		return $this;
	}
	
	
	
	
	
	/*
	 * Get categories by input name
	 * and param like (view, generic, engine, parts)
	 * and return array of finded categories list
	 *
	 * @param String $param - Name of this param like (view, generic, engine, parts)
	 * @param String $name - Name of the input category name
	 *
	 * @return Category - Object self instance, all data must be set in the _data
	 */
	public function getCategories($param = 'view', $name = NULL)
	{
		$result = array();
		$model = MongoModel::factory('Categories');
		$model->selectDB();
		
		switch($param)
		{
			case 'engine':
				$request = Request::current()->param('path', NULL);
				$path = explode('/', $request);
				
				$current = $model
					->where('param', '=', 'generic')
					->where('parentName', '=', $path[1])
					->where('name', '=', $path[2])
					->find();
					
				if( $current->loaded() )
				{
					$this->setCurrent($current->lastDocument());
					
					$this->createSearchIndex('categories', 'name', $param, $name);
					$modelParent = MongoModel::factory('Categories');
					$modelParent->selectDB();
					
					$parent = $modelParent
						->where('_id', '=', new MongoId($current->get('parentId')))
						->where('name', '=', $current->get('parentName'))
						->find();
					
					if( $parent->loaded() )
					{
						$parentCategory = $parent->lastDocument();
						$currentCategory = $current->lastDocument();
						
						$model->unload();
						$child = $model
							->where('param', '=', $param)
							->where('parentId', '=', $currentCategory['_id']['$id'] )
							->sort('name')
							->find_all();
							
						if( !empty($child) )
						{
							$this->clearOffsets();
							foreach( $child as $key => $item )
							{
								$this->offsetSet($key, $item);
							}
						}else
						{
							$url = preg_replace(array('/{view_id}/', '/{generic_id}/'), array($parentCategory['link'], $currentCategory['link']), self::ENGINE_URL);
							$page = $this->searchPage($url);
		
							$htmlNodes = Domparser::getInstance($page);
							$htmlNodes->skipRow(FALSE);
							$htmlNodes->parseDocument("div");
							$htmlNodes->parseContainer("table");
							$htmlNodes->parseRows('tr', 'td');
							
							$htmlNodes->createEngine('parts', $currentCategory['_id']['$id'], $currentCategory['name'], $parentCategory['name']);
							
							if( $this->offsetSize() > 0 )
							{
								$offsets = $this->getOffsets();
								
								$this->clearOffsets();
								foreach( $offsets as $key => $item )
								{
									$modelView = MongoModel::factory('Categories');
									$modelView->selectDB();	
									
									$row = $modelView
										->where('name', '=', $item['name'])
										->where('param', '=', 'parts')
										->where('parentName', '=', $currentCategory['name'])
										->sort('name')
										->find();
									
									if( !$row->loaded() )
									{
										$item['date_create'] = new MongoDate();
										$modelView->values($item);
										$modelView->save();			
										
										$this->offsetSet($key, $modelView->lastDocument());
									}else
									{
										$modelView->set('parentId', $currentCategory['_id']['$id']);
										$modelView->save();	
										
										$this->offsetSet($key, $row->lastDocument());
									}
								}
							}
						}
					}
				}
				
				break;
			case 'generic':
				$current = $model
					->where('param', '=', 'view')
					->where('parentId', '=', 'root')
					->where('name', '=', $name)
					->find();
					
				if( $current->loaded() )
				{
					$this->setCurrent($current->lastDocument());
					
					$this->createSearchIndex('categories', 'name', $param, $name);
					$currentCategory = $current->lastDocument();
					$this->setMetaData($currentCategory);
					
					$model->unload();
					$child = $model
						->where('param', '=', $param)
						->where('parentId', '=', $currentCategory['_id']['$id'])
						->sort('name')
						->find_all();
					
					if( !empty($child) )
					{
						$this->clearOffsets();
						foreach( $child as $key => $item )
						{
							$this->offsetSet($key, $item);
						}
					}else
					{
						$url = preg_replace('/{view_id}/', $currentCategory['link'], self::GENERIC_URL);
						$page = $this->searchPage($url);
	
						$htmlNodes = Domparser::getInstance($page);
						$htmlNodes->skipRow(FALSE);
						$htmlNodes->parseDocument("div");
						$htmlNodes->parseContainer("table");
						$htmlNodes->parseRows('tr', 'td');
						
						$htmlNodes->createView($param, $currentCategory['_id']['$id'], $currentCategory['name']);
						
						if( $this->offsetSize() > 0 )
						{
							$offsets = $this->getOffsets();
							
							$this->clearOffsets();
							foreach( $offsets as $key => $item )
							{
								$modelView = MongoModel::factory('Categories');
								$modelView->selectDB();	
								
								$row = $modelView
									->where('name', '=', $item['name'])
									->where('param', '=', $param)
									->where('parentId', '=', $currentCategory['_id']['$id'])
									->sort('name')
									->find();
								
								if( !$row->loaded() )
								{
									$item['date_create'] = new MongoDate();
									$modelView->values($item);
									$modelView->save();			
									
									$this->offsetSet($key, $modelView->lastDocument());
								}
								
								$this->offsetSet($key, $row->lastDocument());
							}
						}
					}
				}
				
				break;
			default:
				$this->createSearchIndex('categories', 'name', $param, $name);
				$result = $model
					->where('param', '=', 'view')		
					->sort('name')		
					->find_all();
				
				if( empty( $result ) )
				{
					$url = self::CATEGORY_VIEW;
					$page = $this->searchPage($url);

					$htmlNodes = Domparser::getInstance($page);
					$htmlNodes->skipRow(FALSE);
					$htmlNodes->parseDocument("div");
					$htmlNodes->parseContainer("table");
					$htmlNodes->parseRows('tr', 'td');
					
					$htmlNodes->createView();	
					
					if( $this->offsetSize() > 0 )
					{
						$offsets = $this->getOffsets();
						
						$this->clearOffsets();
						foreach( $offsets as $key => $item )
						{
							$modelView = MongoModel::factory('Categories');
							$modelView->selectDB();	
							
							$row = $modelView
								->where('name', '=', $item['name'])
								->where('param', '=', 'view')
								->where('parentId', '=', 'root')
								->sort('name')
								->find();
							
							if( !$row->loaded() )
							{
								$item['date_create'] = new MongoDate();
								$modelView->values($item);
								$modelView->save();			
								
								$this->offsetSet($key, $modelView->lastDocument());
							}
							$this->offsetSet($key, $row->lastDocument());
						}
					}
				}else
				{
					$this->clearOffsets();
					foreach( $result as $key => $item )
					{
						$this->offsetSet($key, $item);
					}
				}
					
				break;
		}
		
		return $this;
		
	}
	
	
	/*
	 * Search data in the database
	 * by input name
	 *
	 * @param String $name - String article name
	 *
	 * @return Object Category - Return self class instance
	 */
	public function findData($name)
	{
		$this->createSearchIndex('categories', 'name', 'search', $name);

		$model = MongoModel::factory('Categories');
		$model->selectDB();	
		
		
		$rows = $model
			->where('name', 'regex', "/$name/is")
			->where('param', '=', 'parts')
			->sort('name')
			->find_all();
		
		if( !empty($rows) )
		{
			$this->clearOffsets();
			foreach( $rows as $key => $item )
			{
				$this->offsetSet($key, $item);
			}	
			
			$this->refreshData('link');
		}
		
		return $this;
	}
	
	
	/*
	 * Get single parts by redirect URI
	 * beacouse this URL will be recirect us
	 *
	 * @param String $uri - Current URI to search
	 *
	 * @return Object Category - Return self class instance
	 */
	public function getSingleCategory($uri = NULL)
	{
		if( !is_null( $uri ) )
		{
			$url = self::PARTS_URL . trim( $uri, '/' );
			//$page = $this->searchPage($url);
			//print_r( $url );
			
		}
		
		return $this;
	}
	
	/*
	 * Remote search data on the server
	 * if is not find in the database
	 *
	 * @param String $name - String article name
	 *
	 * @return Object Category - Return self class instance
	 */
	public function searchData($name)
	{
		$url = preg_replace('/{category}/', urlencode($name), self::CATEGORY_URL);
		
		$page = $this->searchPage($url);
		
		if ( !empty( $page ) )
		{
			$this->createSearchIndex('categories', 'name', 'search', $name);
			
			$htmlNodes = Domparser::getInstance($page);
			$htmlNodes->parseDocument("#result-by-engine");
			$htmlNodes->parseContainer("table");
			$htmlNodes->parseRows('tr', 'td');
			$htmlNodes->createCategories();
			
			if( $this->offsetSize() > 0 )
			{
				$offsets = $this->getOffsets();
				
				$this->clearOffsets();
				$__data = array();
				
				foreach( $offsets as $key => $item )
				{
					$model = MongoModel::factory('Categories');
					$model->selectDB();	
					
					$row = $model
						->where('name', '=', $item['name'])
						->where('auto', '=', $item['auto'])
						->where('param', '=', 'parts')
						->sort('name')
						->find();
					
					
					if( !$row->loaded() )
					{
						$item['date_create'] = new MongoDate();
						
						$model->values($item);
						$model->save();			
						
						//$__data[ $item['link'] ] = $model->lastDocument();
						$this->offsetSet($key, $model->lastDocument());
					}else
					{
						$model->set('auto', $item['auto']);
						$model->set('fluent', $item['fluent']);
						$model->set('cilinder', $item['cilinder']);
						$model->set('clapan_per_cilinder', $item['clapan_per_cilinder']);
						$model->set('diametr_porshen', $item['diametr_porshen']);
						$model->set('hod_porshen', $item['hod_porshen']);
						$model->set('work_obiem', $item['work_obiem']);
						$model->set('date_create', new MongoDate());
						$model->save();	
						
						//$__data[ $item['link'] ] = $row->lastDocument();
						$this->offsetSet($key, $row->lastDocument());
					}
				}
				
				$this->refreshData('article');
			}
		}
		
		return $this;
	}
}