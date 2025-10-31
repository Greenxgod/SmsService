<?php
$config = [
    'id' => 'sms-verification',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'sms-verification-key',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                // API
                'POST api/sms/send' => 'api/sms/send',
                'POST api/sms/verify' => 'api/sms/verify',
                
                // Главная страница - верификация
                '' => 'site/index',
                'verification' => 'site/verification',
            ],
        ],
    ],
];

return $config;