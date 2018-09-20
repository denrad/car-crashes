<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'language'   => 'ru',
    'basePath'   => dirname(__DIR__),
    'aliases'    => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'bootstrap'  => ['log'],
    'components' => [
        'cache'  => [
            'class' => 'yii\caching\FileCache',
        ],
        'mailer' => [
            'class'            => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
        ],
        'log'    => [
            'targets' => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db'     => [
            'class'   => 'yii\db\Connection',
            'dsn'     => 'sqlite:' . __DIR__  .'/../runtime/config.sqlite',
            'charset' => 'utf8',
        ],

        'mongodb' => [
            'class' => '\yii\mongodb\Connection',
            'dsn'   => 'mongodb://localhost/dtp',
        ],

        'accidentHash' => [
            'class' => \app\components\AccidentHash::class,
        ],

        'urlManager' => [
            'baseUrl'         => YII_ENV_PROD ? 'http://car-crashes.ru' : 'http://dtp.env',
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules'           => [
                '/about'                     => '/site/about',
                '<region:\w+>'               => '/accident/index',
                '/accident/<id:([0-9a-z])+>' => '/accident/view',
            ],
        ],
    ],
    'params'     => $params,
];

return $config;
