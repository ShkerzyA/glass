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
                    // …
                    array(
                        'class'=>'ext.db_profiler.DbProfileLogRoute',
                        'countLimit' => 1, // How many times the same query should be executed to be considered inefficient
                        //'slowQueryMin' => 0.01, // Minimum time for the query to be slow
                        //'showInFireBug' => true,
                    ),
            ),
        ),
	),
));