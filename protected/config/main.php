<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'projectBuildr',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
                'application.models.*',
		'application.components.*',
                'application.components.helpers.*',
                'application.helpers.*',
                'ext.*',
                'ext.helpers.*',
                'ext.giix-components.*',
        ),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
                        'class'=>'system.gii.GiiModule',
			'password'=>'cocacola',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
                        'generatorPaths' => array(
                            'application.gii'  //nested set  Model and Crud templates
                        ),
                ),
	),

	// application components
	'components'=>array(
            'cache' => array('class' => 'system.caching.CDummyCache'),
            'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
                ),
		// uncomment the following to enable URLs in path-format
                'urlManager'=>array(
                    'urlFormat'=>'path',
                    'showScriptName'=>false,
                    'rules'=>array(
                                ''=>'site/index',
                                'parts'=>'category/view/id/1',
                                'projects'=>'category/view/id/2',
                                'part/<id:\d+>'=>'part/view',
                                'tag/<name>'=>'site/tag',
                                'part/addSupplier'=>'part/addSupplier',
//                                'part/update/<id:\d+>'=>'part/update',
                                'catalog/<id:\d+>'=>'part/catalog',
                                'user/<id:\d+>'=>'user/view',
                                'category'=>'category/index',
                                'category/fetchTree'=>'category/FetchTree',
                                'gii'=>'gii',
//                                'post/<year:\d{4}>/<title>'=>'post/read',
                        
                    ),
                ),		
            /*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		*/
		// uncomment the following to use a MySQL database
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=projectbuildr',
			'emulatePrepare' => true,
			'username' => 'projectbuildr',
			'password' => 'q9aqXLFCY53bSXJs',
			'charset' => 'utf8',
                        'tablePrefix' => '',
                ),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'mail@thomas-kramm.de',
	),
);