<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'AXEO CalCart',
    'sourceLanguage' => 'en',
    'language' => 'en',
    // preloading 'log' component
    'preload' => array(
        'log',
        'bootstrap'
    ),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
    // 'application.modules.admin.models.*', 
    ),
    'modules' => array(
        // uncomment the following to enable the Gii tool
        'admin',
    /* 'gii'=>array(
      'class'=>'system.gii.GiiModule',
      'password'=>'jack',
      'generatorPaths'=>array(
      'bootstrap.gii', // since 0.9.1
      ),
      'ipFilters'=>array('*','::1'),
      ), */
    ),
    // application components
    'components' => array(
        'widgetFactory' => array(
            'widgets' => array(
                'CJuiDialog' => array(
                    'themeUrl' => '/ExpenseTracker/css/',
                    'theme' => 'bootstrap',
                ),
                'CJuiAutoComplete' => array(
                    'themeUrl' => '/ExpenseTracker/css/',
                    'theme' => 'bootstrap',
                ),
                'CJuiDatePicker' => array(
                    'themeUrl' => '/ExpenseTracker/css/',
                    'theme' => 'bootstrap',
                ),
                'CJuiTabs' => array(
                    'themeUrl' => '/ExpenseTracker/css/',
                    'theme' => 'bootstrap',
                ),
            ),
        ),
        'bootstrap' => array(
            'class' => 'ext.bootstrap.components.Bootstrap',
            'responsiveCss' => true,
            'coreCss' => true,
        ),
        'user' => array(
            'allowAutoLogin' => true,
            'loginUrl' => array('site/login'),
            'class' => 'ValidateUser',
        ),
        // uncomment the following to enable URLs in path-format
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<id:\d+>' => 'site/index',
            ),
        ),
        /*
          'db'=>array(
          'connectionString' => 'mysql:host=localhost;dbname=astxe_calcart',
          //			'connectionString' => 'mysql:host=instance14085.db.xeround.com;port=9482;dbname=astxe_calcart',
          'emulatePrepare' => true,
          'username' => 'calcart',
          'password' => 'net123',
          'charset' => 'utf8',
          ),
         */

        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=calcart_calcart',
//			'connectionString' => 'mysql:host=instance14085.db.xeround.com;port=9482;dbname=astxe_calcart',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
//			'username' => 'calcart',
//			'password' => ']+ka6I#B#$3^',
            'charset' => 'utf8',
        ),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            // uncomment the following to show log messages on web pages
            /*
              array(
              'class'=>'CWebLogRoute',
              ), */
            ),
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'info@axeo.com',
        // Email configuration
        'mailSenderEmail' => 'noreply@axeo.net',
        'mailSenderName' => 'Expense Tracker',
        'mailHost' => 'smtp.axeo.net',
        'mailSMTPAuth' => true,
        'mailUsername' => 'noreply@axeo.net',
        'mailPassword' => 'MX{+%;z;cIGO',
        'mailSendMultiples' => 5,
    ),
);
