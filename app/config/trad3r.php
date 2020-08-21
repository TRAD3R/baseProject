<?php

use App\Logger\EmailTarget;
use App\Mail\SmtpTransport;
use yii\db\Connection;
use yii\helpers\ArrayHelper;
use yii\swiftmailer\Mailer;

$config = [
    'components' => [
        'mailer'      => [
            'class'            => Mailer::class,
            'useFileTransport' => false,
            'transport' => [
                'class' => SmtpTransport::class,
            ]
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => EmailTarget::class,
                    'levels' => ['error', 'warning'],
                    'message' => [
                        'from' => ['log@trad3r'],
                        'to'   => ['tatusr@gmail.com']
                    ]
                ],
            ]
        ],
        'db' => [
            'class'                 => Connection::class,
            'dsn'                   => 'mysql:host=127.0.0.1;dbname=trad3r',
            'username'              => '',
            'password'              => '',
            'charset'               => 'utf8',
            'tablePrefix'           => '',
        ]
    ],
    'params' => is_file(dirname(__DIR__ ) . '/config/trad3r_params_local.php') ?
        ArrayHelper::merge(
            require dirname(__DIR__) . '/config/trad3r_params.php',
            require dirname(__DIR__) . '/config/trad3r_params_local.php'
            ) :
        require dirname(__DIR__) . '/config/trad3r_params.php'
];

return $config;