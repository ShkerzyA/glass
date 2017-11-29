<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Онкологический диспансер',
	'language' => 'ru',
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.helpers.*',
		'application.widgets.*',
	),

	'modules'=>array(
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123',
			'generatorPaths'=>array('application.gii'),
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		'yiiadmin'=>array(
                'password'=>'123',
                'registerModels'=>array(
                    'application.models.Personnel',
                    'application.models.PersonnelPostsHistory',
                    //'application.models.*',
                ),
                //'excludeModels'=>array(),
        ),
		
	),

	// application components
	'components'=>array(
		'Tornado'=>array(
			'class'=> "Tornado",
			),
		'user'=>array(
			// enable cookie-based authentication
			'class' => 'WebUser',
			'allowAutoLogin'=>true,
		),

	'authManager' => array(
    // Будем использовать свой менеджер авторизации
    	'class' => 'PhpAuthManager',
    // Роль по умолчанию. Все, кто не админы, модераторы и юзеры — гости.
    	'defaultRoles' => array('guest'),
	),
		// uncomment the following to enable URLs in path-format
	'clientScript'=>array(
	    'packages' => array(
	       // Уникальное имя пакета
	    	'tornado' =>array(
	    		'baseUrl' => '/glass/js/tornado/',
	            // Если включен дебаг-режим, то подключает /js/highcharts/highcharts.src.js
	            // Иначе /js/highcharts/highcharts.js
	            //'js'=>array('backbone.js','backbone.localStorage.js','main.js','underscore.js'),
	            'js'=>array('tornado.js'),
	            //'js'=>array(YII_DEBUG ? 'highcharts.src.js' : 'highcharts.js'),
	            // Подключает файл /js/highcharts/highcharts.css
	          	 // 'css' => array('highcharts.css'),
	            // Зависимость от другого пакета
	            'depends'=>array('jquery'),
	    		),

	    	'alf' =>array(
	    		'baseUrl' => '/glass/js/alf/',
	            // Если включен дебаг-режим, то подключает /js/highcharts/highcharts.src.js
	            // Иначе /js/highcharts/highcharts.js
	            //'js'=>array('backbone.js','backbone.localStorage.js','main.js','underscore.js'),
	            'js'=>array('alf.js'),
	            //'js'=>array(YII_DEBUG ? 'highcharts.src.js' : 'highcharts.js'),
	            // Подключает файл /js/highcharts/highcharts.css
	          	 // 'css' => array('highcharts.css'),
	            // Зависимость от другого пакета
	            'depends'=>array('jquery'),
	    		),

	    	'quickq' =>array(
	    		'baseUrl' => '/glass/js/quickq/',
	            // Если включен дебаг-режим, то подключает /js/highcharts/highcharts.src.js
	            // Иначе /js/highcharts/highcharts.js
	            //'js'=>array('backbone.js','backbone.localStorage.js','main.js','underscore.js'),
	            'js'=>array('quickq.js'),
	            //'js'=>array(YII_DEBUG ? 'highcharts.src.js' : 'highcharts.js'),
	            // Подключает файл /js/highcharts/highcharts.css
	          	 // 'css' => array('highcharts.css'),
	            // Зависимость от другого пакета
	            'depends'=>array('jquery'),
	    		),

	    	'jquery.cookie' =>array(
	    		'baseUrl' => '/glass/js/jquery.cookie/',
	            // Если включен дебаг-режим, то подключает /js/highcharts/highcharts.src.js
	            // Иначе /js/highcharts/highcharts.js
	            //'js'=>array('backbone.js','backbone.localStorage.js','main.js','underscore.js'),
	            'js'=>array('jquery.cookie.js'),
	            //'js'=>array(YII_DEBUG ? 'highcharts.src.js' : 'highcharts.js'),
	            // Подключает файл /js/highcharts/highcharts.css
	          	 // 'css' => array('highcharts.css'),
	            // Зависимость от другого пакета
	            'depends'=>array('jquery'),
	    		),
	       	'customfields' => array(
	            // Где искать подключаемые файлы JS и CSS
	            'baseUrl' => '/glass/js/customfields/',
	            // Если включен дебаг-режим, то подключает /js/highcharts/highcharts.src.js
	            // Иначе /js/highcharts/highcharts.js
	            'js'=>array('custom.fields.js'),
	            //'js'=>array(YII_DEBUG ? 'highcharts.src.js' : 'highcharts.js'),
	            // Подключает файл /js/highcharts/highcharts.css
	          	 // 'css' => array('highcharts.css'),
	            // Зависимость от другого пакета
	            'depends'=>array('jquery'),
	        ),
	        'actions' => array(
	            // Где искать подключаемые файлы JS и CSS
	            'baseUrl' => '/glass/js/actions/',
	            // Если включен дебаг-режим, то подключает /js/highcharts/highcharts.src.js
	            // Иначе /js/highcharts/highcharts.js
	            'js'=>array('actions.js'),
	            //'js'=>array(YII_DEBUG ? 'highcharts.src.js' : 'highcharts.js'),
	            // Подключает файл /js/highcharts/highcharts.css
	          	 // 'css' => array('highcharts.css'),
	            // Зависимость от другого пакета
	            'depends'=>array('jquery'),
	        ),
	        'userjs' => array(
	            // Где искать подключаемые файлы JS и CSS
	            'baseUrl' => '/glass/js/userjs/',
	            // Если включен дебаг-режим, то подключает /js/highcharts/highcharts.src.js
	            // Иначе /js/highcharts/highcharts.js
	            'js'=>array('user.js'),
	            //'js'=>array(YII_DEBUG ? 'highcharts.src.js' : 'highcharts.js'),
	            // Подключает файл /js/highcharts/highcharts.css
	          	 // 'css' => array('highcharts.css'),
	            // Зависимость от другого пакета
	            'depends'=>array('jquery'),
	        ),
	        'sigma' => array(
	            // Где искать подключаемые файлы JS и CSS
	            'baseUrl' => '/glass/js/sigma/',
	            // Если включен дебаг-режим, то подключает /js/highcharts/highcharts.src.js
	            // Иначе /js/highcharts/highcharts.js
	            'js'=>array(
	            	'src/sigma.core.js',
					'src/conrad.js',
					'src/utils/sigma.utils.js',
					'src/utils/sigma.polyfills.js',
					'src/sigma.settings.js',
					'src/classes/sigma.classes.dispatcher.js',
					'src/classes/sigma.classes.configurable.js',
					'src/classes/sigma.classes.graph.js',
					'src/classes/sigma.classes.camera.js',
					'src/classes/sigma.classes.quad.js',
					'src/classes/sigma.classes.edgequad.js',
					'src/captors/sigma.captors.mouse.js',
					'src/captors/sigma.captors.touch.js',
					'src/renderers/sigma.renderers.canvas.js',
					'src/renderers/sigma.renderers.webgl.js',
					'src/renderers/sigma.renderers.svg.js',
					'src/renderers/sigma.renderers.def.js',
					'src/renderers/webgl/sigma.webgl.nodes.def.js',
					'src/renderers/webgl/sigma.webgl.nodes.fast.js',
					'src/renderers/webgl/sigma.webgl.edges.def.js',
					'src/renderers/webgl/sigma.webgl.edges.fast.js',
					'src/renderers/webgl/sigma.webgl.edges.arrow.js',
					'src/renderers/canvas/sigma.canvas.labels.def.js',
					'src/renderers/canvas/sigma.canvas.hovers.def.js',
					'src/renderers/canvas/sigma.canvas.nodes.def.js',
					'src/renderers/canvas/sigma.canvas.edges.def.js',
					'src/renderers/canvas/sigma.canvas.edges.curve.js',
					'src/renderers/canvas/sigma.canvas.edges.arrow.js',
					'src/renderers/canvas/sigma.canvas.edges.curvedArrow.js',
					'src/renderers/canvas/sigma.canvas.edgehovers.def.js',
					'src/renderers/canvas/sigma.canvas.edgehovers.curve.js',
					'src/renderers/canvas/sigma.canvas.edgehovers.arrow.js',
					'src/renderers/canvas/sigma.canvas.edgehovers.curvedArrow.js',
					'src/renderers/canvas/sigma.canvas.extremities.def.js',
					'src/renderers/svg/sigma.svg.utils.js',
					'src/renderers/svg/sigma.svg.nodes.def.js',
					'src/renderers/svg/sigma.svg.edges.def.js',
					'src/renderers/svg/sigma.svg.edges.curve.js',
					'src/renderers/svg/sigma.svg.labels.def.js',
					'src/renderers/svg/sigma.svg.hovers.def.js',
					'src/middlewares/sigma.middlewares.rescale.js',
					'src/middlewares/sigma.middlewares.copy.js',
					'src/misc/sigma.misc.animation.js',
					'src/misc/sigma.misc.bindEvents.js',
					'src/misc/sigma.misc.bindDOMEvents.js',
					'src/misc/sigma.misc.drawHovers.js',
					'plugins/sigma.plugins.neighborhoods/sigma.plugins.neighborhoods.js',
					'plugins/sigma.layout.forceAtlas2/supervisor.js',
					'plugins/sigma.layout.forceAtlas2/worker.js',
	            ),
	            //'js'=>array(YII_DEBUG ? 'highcharts.src.js' : 'highcharts.js'),
	            // Подключает файл /js/highcharts/highcharts.css
	          	 // 'css' => array('highcharts.css'),
	            // Зависимость от другого пакета
	            'depends'=>array('jquery'),
	          )

    	)
	),		


		'urlManager'=>array(
			'showScriptName'=>false,
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		'cache'=>array('class'=>'system.caching.CFileCache'),
       

		'db'=>array(
			'connectionString' => 'pgsql:host=glass;dbname=glassNG',
			'username' => 'postgres',
			'password' => '123',
			'charset' => 'utf8',
        	'schemaCachingDuration'=>3600,
		),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
	),


	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(

		'tornado'=>'10.126.83.86:8888',
		// this is used in contact page
		'adminEmail'=>'no@no.ru',
	),
);
