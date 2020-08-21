<?php
/**
 * Application configuration shared by all test types
 */
$config = yii\helpers\ArrayHelper::merge(
    require dirname(__DIR__) . '/config.php',
    require dirname(__DIR__) . '/common.php',
    require dirname(__DIR__) . '/trad3r.php',
    require dirname(__DIR__) . '/config_local_trad3r.php',
    [
        'id' => 'whocpa-tests',
        'language' => 'en-US',
        'components' => [
            'mailer' => [
                'useFileTransport' => true, // отключаем отправку писем
            ],
            'urlManager' => [
                'showScriptName' => true, // возвращаем полные имена файлов (без ЧПУ)
            ],
            'db' => [
                'dsn' => '',
            ],
        ],
    ],
    require __DIR__ . '/test_local.php'
);

return $config;