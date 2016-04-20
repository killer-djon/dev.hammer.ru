<?php
header('Content-Type: text/html; charset=utf-8');
/** Error reporting */
error_reporting(E_ALL);
set_time_limit(0);
require_once dirname(__FILE__) . '/Classes/PHPExcel.php';
function build_tree(&$tree, $parentId = 'parentId') {
	
    $result = array();
    
	if( is_array($tree) && count( $tree ) ){
		
		foreach( $tree as $key => &$item ){
			
			if( ! isset($item[$parentId]) || empty($item[$parentId]) ){		
				$result[] =& $item;					
			}else
			{
				$tree[ $item[$parentId] ]["children"][] = &$item;					
			}
		}
	}
	
	return $result;
}

function is_assoc(array $array)
{
	// Keys of the array
	$keys = array_keys($array);
	// If the array keys of the keys match the keys, then the array must
	// not be associative (e.g. the keys array looked like {0:0, 1:1...}).
	return array_keys($keys) !== $keys;
}

function flatten($array)
{
	$is_assoc = is_assoc($array);
	$flat = array();
	foreach ($array as $key => $value)
	{
		if (is_array($value))
		{
			$flat = array_merge($flat, flatten($value));
		}
		else
		{
			if ($is_assoc)
			{
				$flat[$key] = $value;
			}
			else
			{
				$flat[] = $value;
			}
		}
	}
	return $flat;
}
echo '<pre>';
$objPHPExcel = PHPExcel_IOFactory::load("catalogs/Кросс Аналоги2.xlsx");
$objWorksheet = $objPHPExcel->getSheet(5);

$arrExcel = $objWorksheet->toArray();


if( !empty($arrExcel) )
{
	$name = '';
	$result = array();
	$result2 = array();
	$result3 = array();
	
	foreach( $arrExcel as $index => $row )
	{
		if( $index == 0 ) continue;
		
		$result[] = array(
			'identifier'	=> str_pad($row[0], (strlen($row[0]) + 2), '0', STR_PAD_LEFT),
			'article'	=> $row[1],
			'manufacture'	=> $row[2],
			'name'	=> $row[3],
			"clear_article" => preg_replace('/[^\w+]/is', '', $row[1]),
			"parentName" => "",
			"parentId" => "",
			"groupName" => "",
			"category" => "",
			"link" => "",
			"date_create" => new MongoDate(),
		);
	}
	
	$res = array();
	$tree = build_tree($result, 'identifier');
	
	foreach( $tree as $key =>& $item )
	{
		$child = array();
		foreach( $item['children'] as $index => $value )
		{
			$child[] = $value['article'];
		}
		
		array_walk($item['children'], function(&$arItem) use ($child, $res){
			$arItem['cross_article'] = $child;
		});
		
		$res[] = $item;
	}
	
	
	if( is_array($res) )
	{
		foreach( $res as $key => $item )
		{
			if( isset( $item['children'] ) )
			{
				$result2 = array_merge($result2, $item['children']);
			}
		}
	}
	
		
	$options = [
		'authMechanism' => 'SCRAM-SHA-1',
		'db'		=> 'dev_hammer_v3',
		'username'	=> 'hammer',
		'password'	=> 'nyFFqv2015',
	];
	$m = new MongoClient("mongodb://localhost:27017", $options);
	$collection = $m->selectCollection('dev_hammer_v3', 'cross_products');
	
		
	if( $collection instanceof MongoCollection && is_array( $result2 ) )
	{
		$dbRes = $collection->batchInsert($result2, ['w'	=> 1]);
		print_r( $dbRes );
	}
}
