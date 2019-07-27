<?php

$config_main = [
    'id' => \App\App::CONFIG_MODULE_MAIN,
    'language' => \App\AppHelper::getProjectLanguage(),
    'controllerNamespace' => \App\AppHelper::getProjectControllerNamespace(\App\App::CONFIG_MODULE_MAIN),
    'layout' => \App\AppHelper::getProjectLayout(),
    'modules' => [

    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'nWfDUaJRNtnfdgl3kWOUW8d8sEra',
        ],
        'user' => [
        ],
        'urlManager' => [
            'rules' => require 'url_manager_rules.php'
        ]
    ]
];

return $config_main;