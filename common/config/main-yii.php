<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
/*
		'cache' => [
		   'class' => 'yii\redis\Cache',
		   //'servers' => [
		   //    [
		   //        'host' => 'localhost',
		   //        'port' => 11211,
		   //        'weight' => 100,
		   //    ],
		   //],
		],
		
		'redis' => [
			'class' => 'yii\redis\Connection',
			'hostname' => 'localhost',
			'port' => 6379,
			'database' => 0,
		],
*/
    //    'errorHandler' => [
    //        'errorAction' => 'site/error',
    //    ],
    ],

];
