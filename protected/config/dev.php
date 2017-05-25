<?php
return CMap::mergeArray(
	require(dirname(__FILE__).'/main.php'),
	array(
	// application components
	'components'=>array(
	

	
		'db'=>array(
			'connectionString' => 'pgsql:host=glass;dbname=glassNG',
			'username' => 'postgres',
			'password' => '123',
			'charset' => 'utf8',
			'enableProfiling'=>true,
        	'enableParamLogging' => true,
        	'schemaCachingDuration'=>3600,
		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CWebLogRoute',
                    'levels'=>'profile', //Чтоб еще увидеть правила доступа, закомментить levels
            		#'categories'=>'system.*',
            		#'except'=>'system.db.ar.*',
            		'showInFireBug' => true
                ),
            ), 
        ), 
	),
));