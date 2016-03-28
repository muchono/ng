<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'NetGeron',
    'language' => 'en',

	// preloading 'log' component
	'preload'=>array('log'),
    
	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),
    
    'behaviors' => array(
        'runEnd' => array(
           'class' => 'application.components.WebApplicationEndBehavior',
        ),
    ),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'admin',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			//'ipFilters'=>array('127.0.0.1','::1'),
		),
	),
    

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
        'mail'=>array(
            'class'=>'CMail',
        ),
        'curl' => array(
            'class' => 'ext.Curl.Curl',
            'options' => array(CURLOPT_FOLLOWLOCATION => false),
        ),
        // 
        // // ...
		// uncomment the following to enable URLs in path-format
/*
		'urlManager'=>array(
        ''
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
*/
        /*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		// uncomment the following to use a MySQL database
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=ng',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
            //'enableParamLogging'=>true,
            'enableProfiling'=>true,
		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			//'errorAction'=>'front/error',
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
				),*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
    'params'=>array(
        'emailNotif'=> array(
            'from_email' => 'info@netgeron.com',
            'from_name'  => 'Netgeron Team',
            'payed_transaction_email'  => 'manituforever@gmail.com',
        ),
        'recapcha'=>array(
            'secret' => '6LfMmQMTAAAAAKyOk7yKqFgYl9jqRQGosD1jz_l-',
            'sitekey' => '6LfMmQMTAAAAAKK6Uvp4m4UEfr2NCikXA6GIKTd6',
        ),
    ),
);