<?php
return [
    'bootstrap'  => [
        'debug',
        'gii',
    ],
    'components' => [
        'log' => [
            'traceLevel' => 3,
        ],
    ],
    'modules'    => [
        'debug' => [
            'class'      => 'yii\debug\Module',
            'allowedIPs' => ['192.168.1.3'],
            'panels'     => [
                'mongodb' => \yii\mongodb\debug\MongoDbPanel::class,
            ],
        ],
        'gii'   => [
            'class' => 'yii\gii\Module',
        ],
    ],
];