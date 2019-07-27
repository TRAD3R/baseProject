<?php
/**
 * Application configuration shared by all test types
 */
return [
    'id' => 'basic-tests',
    'basePath' => dirname(__DIR__),
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'language' => 'en-US',
    'components' => [
        'db' => [
            'class'                 => \yii\db\Connection::class,
            'dsn'                   => 'mysql:host=127.0.0.1;dbname=trad3r',
            'username'              => '',
            'password'              => '',
            'charset'               => 'utf8',
            'tablePrefix'           => '',
        ],
        'mailer' => [
            'useFileTransport' => true,
        ],
        'assetManager' => [
            'basePath' => '@Web/assets',
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
//        'user' => [
//            'identityClass' => 'app\modules\user\models\User',
//        ],
        'request' => [
            'cookieValidationKey' => 'test',
            'enableCsrfValidation' => false,
            // but if you absolutely need it set cookie domain to localhost
            /*
            'csrfCookie' => [
                'domain' => 'localhost',
            ],
            */
        ],
    ],
    'params' => is_file(dirname(__DIR__ ) . '/config/trad3r_params_local.php') ?
        \yii\helpers\ArrayHelper::merge(
            require dirname(__DIR__) . '/config/trad3r_params.php',
            require dirname(__DIR__) . '/config/trad3r_params_local.php'
        ) :
        require dirname(__DIR__) . '/config/trad3r_params.php'
];
