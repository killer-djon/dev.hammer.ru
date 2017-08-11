<?php defined('SYSPATH') or die('No direct script access.');

class Kohana_Domparser 
{
	/**
	 * Default instance name
	 *
	 * @var  string
	 */
	public static $default = 'default';
	
	/**
	 * Database instances
	 *
	 * @var  array
	 */
	public static $_instance = NULL;
	
	
	/**
	 * phpQuery instance
	 *
	 * @var  phpQueryObject
	 */
	protected $_phpQuery = NULL;
	
	
	/*
	 * This contains test data
	 * but must contains tree array of the container
	 *
	 * @var String $_data
	 */
	protected $_data = NULL;
	
	
	/*
	 * Contains string of the finded container document
	 *
	 * @var String $_document	
	 */
	protected $_document = NULL;
	
	/*
	 * Inner container with detail/categories
	 *
	 * @var String $_container
	 */
	protected $_container = NULL;
	
	/*
	 * Rows of the inner container
	 *
	 * @var Array $_rows
	 */
	protected $_rows = array();
	
	
	/*
	 * Skip first rowon search
	 *
	 * @var Boolean $_skipRow
	 */
	protected $_skipRow = TRUE;
	
	
	/*
	 * Array of the parsed rows of details
	 *
	 * @var Array $_groupDetails
	 */
	protected $_groupDetails = array();
	
	
	
	/*
	 * Create singleton instance
	 * for this phpQuery object	
	 */
	public static function getInstance($str = NULL, $encoding = 'UTF-8')
	{
		if( is_null( Domparser::$_instance ) )
		{
			Domparser::$_instance = new self($str, $encoding);
		}
		
		return Domparser::$_instance;
	}
	
	
	/*
	 * Self constructor of this instance
	 * on create will be get instance of the phpQuery
	 * to the options of this class
	 *
	 * @param String $str - HTML structure of the string	
	 */
	protected function __construct($str = NULL, $encoding = 'UTF-8')
	{
		if ( ! class_exists('phpQuery', FALSE))
		{
			require Kohana::find_file('vendor', 'phpQuery/phpQuery');
		}
		
		if( !is_null( $str ) )
		{
			$this->_phpQuery = phpQuery::newDocumentHTML($str, $encoding);	
		}else
		{
			$this->_phpQuery = phpQuery::newDocument(null, $encoding);
		}
		
	}
	
	
	/*
	 * Get created link of the phpQuery
	 * from options at this class
	 *
	 * @return phpQueryObject
	 */
	public function getPq()
	{
		return $this->_phpQuery;
	}
	
	
	
	/*
	 * Return string represents of the 
	 * finded document's container
	 *
	 * @return String
	 */
	public function getDocument()
	{
		return $this->_document;
	}
	
	
	
	/*
	 * Return object of the container
	 *
	 * @return phpQueryObject
	 */
	public function getContainer()
	{
		return $this->_container;
	}
	
	
	/*
	 * Return object of the rows
	 *
	 * @return phpQueryObject
	 */
	public function getRows()
	{
		return $this->_rows;
	}
	
	
	/*
	 * Return details arange by group itself
	 *
	 * @return Array details with group
	 */
	public function getGroupDetails()
	{
		return $this->_groupDetails;
	}
	
	
	/*
	 * Parse document on the _data
	 * this method will parse real HTML document
	 * and collect all on the options of this class
	 *
	 * @param String $containerID - Main selector of the container
	 *
	 * @return Domparser
	 */
	public function parseDocument($containerID)
	{
		$container = $this->getPq()->find($containerID);
		
		$this->_document = $container;
		
		return $this;
	}
	
	
	/*
	 * Parse basic container
	 * and collect cascading all tags
	 * from this string html
	 *
	 * @param String $tagName - Name of the tag which must parse	
	 */
	public function parseContainer($tagName)
	{
		$this->_container = $this->_document->find($tagName);
		
		return $this;
	}
	
	
	public function skipRow($flag = FALSE)
	{
		$this->_skipRow = $flag;
	}
	
	
	/*
	 * Parse basic container
	 * and select all rows from innerContainer
	 * this method will create array with rows
	 *
	 * @param String $tagRows - Name of the tag at row	
	 * @param String $tagCells - Name of the cell tag in the rows
	 */
	public function parseRows($tagRows, $tagCells)
	{
		$rows = $this->_container->find($tagRows);
		
		if( $rows->length() > 0 )
		{
			foreach( $rows as $index => $row )
			{
				if( $this->_skipRow )
				{
					if( $index == 0 ) continue;
				}
				
				$cell = pq($row)->find($tagCells);
				
				if( $cell->length() > 0 )
				{
					$cells = array();
					foreach( $cell as $key => $item )
					{
						$cells[] = pq($item);
					}
					
					$this->_rows[] = $cells;
				}
			}
		}
		
		return $this;
	}
	
	
	/*
	 * Parse from basic container rows with products
	 * in this containers sets 1,2 headers div
	 * and must get second header div
	 * beacouse it is real header
	 *
	 * @param String $tagName - Name of all rows tag
	 */
	public function parseProducts($tagName = 'div', $innerName = 'table', $rowName = 'tr', $cellName = 'td')
	{
		$allRows = $this->_container;
		$groupRows = array();
		
		
		if( $allRows->length() > 0 )
		{
			foreach( $allRows as $key => $row )
			{
				$divId = pq($row)->attr('id');
				if( !empty( $divId ) && preg_match('/^g[\d]/', $divId) )
				{
					$table = pq($row)->find('table');
					
					$groupRows[ pq($row)->prev('div')->htmlOuter() ] = $this->parseDetails($table, $rowName, $cellName);
				}
				
			}
			
			$this->_groupDetails = $groupRows;
		}
		
		return $this;
	}
	
	
	public function parseDetails($table, $tr = 'tr', $td = 'td')
	{
		$rows = $table->find($tr);
		$result = array();
		
		if( $rows->length() > 0 )
		{
			foreach( $rows as $index => $row )
			{
				if( $this->_skipRow )
				{
					if( $index == 0 ) continue;
				}
				
				$cell = pq($row)->find($td);
				
				if( $cell->length() > 0 )
				{
					$cells = array();
					foreach( $cell as $key => $item )
					{
						$cells[] = pq($item);
					}
					
					$result[] = $cells;
					$this->_groupDetails[] = $result;
				}
			}
		}
		
		return $result;
	}
	
	
	
	/*
	 * Create pull array of parsed products
	 * this will be create array of products with groupname
	 *
	 * @param String $categoryName - Category name from uri string
	 * @param ODM $parts - ODM instance of the parts by display products array
	 *
	 * @return void	
	 */
	public function createProducts($categoryName = NULL, $parts = NULL)
	{	
		$product = Product::getInstance();
		
		if( Arr::is_array($this->_groupDetails) && !empty($this->_groupDetails) )
		{
			$i = 0;
			foreach( $this->_groupDetails as $key => $item )
			{
				
				$group = mb_convert_encoding(strip_tags(pq($key)->find('td')->html()), 'UTF-8');
				$groupName = preg_replace('/[^а-яё ]+/ius', '', $group);
				
				
				$result = array();
				foreach( $item as $index => $cell )
				{
					
					if( count($cell) > 1 )
					{
						$articleLink = pq($cell[1])->children('a')->attr('href');
						if( stripos($articleLink, 'catalog_part') !== false )
						{
							$articleField = pq($cell[1])->children('a');
							$article = trim($articleField->text());
							$name = pq($cell[2])->html();
							$manufacture = ( pq($cell[4])->children('img')->length() > 0 ? pq($cell[4])->children('img')->attr('title'):pq($cell[3])->children('img')->attr('title') );
							
							$result = array(
								'name'	=> trim($name),
								'article'	=> $article,
								'clear_article' => preg_replace('/([^\w]+)/', '', $article),
								'manufacture'	=> trim($manufacture),
								'parentName'	=> ( !is_null($parts ) ? $parts->get('name') : '' ),
								'parentId'	=> ( !is_null($parts ) ? $parts->get('_id')->{'$id'} : '' ),
								'groupName'	=> trim($groupName),
								'category'	=> ( !is_null($categoryName) ? $categoryName : '' ),
								'link'	=> $articleLink,
							);
							
							$this->_data[] = $result;
							$product->offsetSet($i, $result);
							$i++;
						}
					}
				}
			}
		}
		
		return $this;
	}
	
	
	public function createView($param = 'view', $parentId = 'root', $parentName = NULL)
	{
		$category = Category::getInstance();
		$rows = $this->getRows();
		
		if( !empty($rows) && count($rows) > 0 )
		{
			$data = array();
			foreach( $rows as $key => $row )
			{
				if( !empty( $row ) )
				{
				    $view_name = $row[0]->text();
				    $clear_name = preg_replace('/[^\w+]/', '', $view_name);

					$href = preg_match('/([\d]+)\);/m', pq($row[0])->find('a')->attr('onclick'), $mathes);
					$data = array(
						'auto'	=> $row[0]->text(),
						'name'	=> $view_name,
						'link'	=> ( isset($mathes[1]) && !empty($mathes[1]) ? $mathes[1] : '' ),
						'param'	=> $param,
						'parentId'	=> $parentId,
						'parentName'	=> $parentName,
                        'clear_name'    => strtolower($clear_name)
					);
					
					$this->_data[] = $data;
					$category->offsetSet($key, $data);
				}
			}
		}
		
		return $this;
	}
	
	
	public function createEngine($param = 'view', $parentId = 'root', $parentName = NULL, $categoryName = NULL)
	{
		$category = Category::getInstance();
		$rows = $this->getRows();
		
		if( !empty($rows) && count($rows) > 0 )
		{
			$data = array();
			foreach( $rows as $key => $row )
			{
				if( !empty( $row ) )
				{
				    $engine_name = $row[1]->text();
                    $clear_name = preg_replace('/[^\w+]/', '', $engine_name);
					$data = array(
						'auto'	=> $categoryName,
						'name'	=> $engine_name,
						'link'	=> pq($row[1])->find('a')->attr('href'),
						'param'	=> $param,
						'parentId'	=> $parentId,
						'parentName'	=> $parentName,
                        'clear_name'    => strtolower($clear_name)
					);
					
					$this->_data[] = $data;
					$category->offsetSet($key, $data);
				}
			}
		}
		
		return $this;
	}
	
	
	/*
	 * This method will create data
	 * from rows
	 *
	 * @return Array $data - Return data with all categories	
	 */
	public function createCategories()
	{
		// instance of the Kohana_Category class
		// this instance will be need to set data at options
		$category = Category::getInstance();
		$rows = $this->getRows();
		
		if( count($rows) > 0 )
		{
			foreach( $rows as $key => $row )
			{
				if( !empty( $row ) )
				{
					$category_name = $row[2]->text();
					$clear_name = preg_replace('/[^\w+]/', '', $category_name);
					$data = array(
						'auto'	=> $row[1]->text(),
						'name'	=> $category_name,
						'link'	=> pq($row[2])->find('a')->attr('href'),
						'fluent'=> trim($row[4]->html()),
						'cilinder'	=> (int)$row[5]->text(),
						'clapan_per_cilinder'	=> (int)$row[6]->text(),
						'diametr_porshen'	=> floatval($row[7]->text()),
						'hod_porshen'	=> floatval($row[8]->text()),
						'work_obiem'	=> (int)$row[9]->text(),
						'param'	=> 'parts',
						'date_create'	=> new MongoDate(),
                        'clear_name'    => strtolower($clear_name)
					);
					
					$this->_data[] = $data;
					$category->offsetSet($key, $data);
					
				}
			}
		}
		
		return $this;
	}
	
	
	/*
	 * Must be return Array 
	 * of the finded data from container
	 * and this array must be multidimensional
	 *
	 * @return Array
	 */
	public function getData()
	{
		return $this->_data;
	}
	
}