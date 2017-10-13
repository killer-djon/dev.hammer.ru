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
$objPHPExcel = PHPExcel_IOFactory::load("catalogs/FKT-AVTO.xlsx");
$objWorksheet = $objPHPExcel->getActiveSheet();

$arrExcel = $objWorksheet->toArray();


if( !empty($arrExcel) )
{
    $options = [
        'authMechanism' => 'SCRAM-SHA-1',
        'db'		=> 'dev_hammer_v3',
        'username'	=> 'hammer',
        'password'	=> 'nyFFqv2015',
    ];
    $m = new MongoClient("mongodb://localhost:27017", $options);
    $collection = $m->selectCollection('dev_hammer_v3', 'cross_products');

    // загружаем кросссы
    $crosses = $initial = $finded = [];
    $resUpdate = [];
    $resInsert = [];
    foreach( $arrExcel as $index => $row )
    {
        if( $index == 0 ) continue;

        $article = $row[1]; // оригинал артикул детали
        $cross_article = $row[2]; // кросс-артикул
        $manufacture = $row[3]; // производитель детали
        $name = $row[4]; // название детали
        $qty = $row[5]; // кол-во
        $price = $row[6]; // цена одной штуки

        if( empty($article) ) continue;

        $initial = [
            'article'	=> $article,
            'manufacture'	=> $manufacture,
            'name'	=> $name,
            "clear_article" => preg_replace('/[^\w+]/is', '', $article),
            "parentName" => "",
            "parentId" => "",
            "groupName" => "",
            "category" => "",
            "link" => "",
            "date_create" => new MongoDate(),
            "cross_article" => [$cross_article]
        ];

        $finded = $collection->findOne(['article' => $article]);
        if( !empty($finded) )
        {
            $cross = !empty($finded['cross_article']) ? array_unique($finded['cross_article']) : [];
            $cross = array_unique(array_merge($cross, [$cross_article]));

            $resUpdate[] = $collection->update(['article' => $article], [
                '$set' => [
                    'cross_article' => $cross
                ]
            ]);
        }else{
            $resInsert[] = $collection->insert($initial, ['w' => 1]);
        }

        $articles[] = $article;
    }

    print_r( $resInsert );

    die();




	/*
	// загружаем наличие
	$prices = [];
	foreach( $arrExcel as $index => $row )
	{
		if( $index == 0 ) continue;

		settype($row[0], 'string');
		settype($row[1], 'string');

		$prices[] = [
			'article'	=> $row[0], // артикул существующей записи
			'clear_article' => preg_replace('/[^\w+]/is', '', $row[0]), // очищенный артикул существующей записи
			'manufacture'	=> $row[1], // производитель
			'name'	=> $row[2], // название детали
			'qty'	=> preg_replace('/[^\d+]/U', '', $row[3]), // кол-во на складе
			'price'	=> sprintf("%01.2f", preg_replace('/ /s', '', $row[4])), // цена шт. детали
			'date_create'	=> new MongoDate() // дата загрузки
		];
	}
	$options = [
		'authMechanism' => 'SCRAM-SHA-1',
		'db'		=> 'dev_hammer_v3',
		'username'	=> 'hammer',
		'password'	=> 'nyFFqv2015',
	];
	$m = new MongoClient("mongodb://localhost:27017", $options);
	$collection = $m->selectCollection('dev_hammer_v3', 'prices');
	
		
	if( $collection instanceof MongoCollection && is_array( $prices ) )
	{
		//$dbRes = $collection->batchInsert($prices, ['w'	=> 1]);
		//print_r( $dbRes );

		foreach( $prices as $index => $price )
		{
			$dbRes = $collection->update([
				'article'	=> $price['article']
			], $price, [
				'upsert'	=> true
			]);

			print_r(  $dbRes);
		}


	}*/

	
	//print_r( $prices );
	/*
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
	*/
}
