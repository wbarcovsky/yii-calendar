<?php

return [

    'basePath'   => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name'       => 'Test Web Application',
    // preloading 'log' component
    'preload'    => ['log'],
    // autoloading model and component classes
    'import'     => [
        'application.models.*',
        'application.components.*',
    ],
    'components' => [
        'user' => [
            // enable cookie-based authentication
            'allowAutoLogin' => true,
        ],
        // uncomment the following to enable URLs in path-format
        /*
        'urlManager'=>[
            'urlFormat'=>'path',
            'rules'=>[
                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
            ),
        ),
        */
        'db' => [
            'connectionString' => 'mysql:host=localhost;dbname=test',
            'emulatePrepare'   => true,
            'username'         => 'root',
            'password'         => 'secret',
            'charset'          => 'utf8',
        ],
        'errorHandler' => [
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ],
        'log' => [
            'class'  => 'CLogRouter',
            'routes' => [
                [
                    'class'  => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ],
            ],
        ],
    ],
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params'     => [
        // this is used in contact page
        'adminEmail' => 'webmaster@example.com',
    ],
];