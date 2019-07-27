<?php
$params = require dirname(__DIR__) . DIRECTORY_SEPARATOR . \App\AppHelper::getProjectParamsFile();
$config = [
    'id' => \App\App::CONFIG_MODULE_CONSOLE,
    'controllerNamespace' => \App\AppHelper::getProjectControllerNamespace(\App\App::CONFIG_MODULE_CONSOLE),
    'defaultRoute' => 'help',
    'controllerMap' => [
        'migrate' => [
            'class' => \yii\console\controllers\MigrateController::class,
            'templateFile' => '@App/Migration/migration.php'
        ]
    ],
    'components' => [
        'urlManager' => [
            'hostInfo' => $params['domains']['main'],
            'baseUrl' => $params['domains']['main'],
            'scriptUrl' => $params['domains']['main'],
            'enablePrettyUrl' => true,
            'showScriptName' => false
        ]
    ]
];

return $config;