<?php

use App\App;
use App\AppHelper;
use App\Components\AdminErrorHandler;
use App\Module\AdminModule;
use App\Models\User;

$config_main = [
    'id' => App::CONFIG_MODULE_MAIN,
    'language' => AppHelper::getProjectLanguage(),
    'controllerNamespace' => AppHelper::getProjectControllerNamespace(App::CONFIG_MODULE_MAIN),
    'layout' => AppHelper::getProjectLayout(),
    'modules' => [
        App::CONFIG_MODULE_ADMIN => [
            'class'               => AdminModule::class,
            'controllerNamespace' => 'Admin\Controllers',
            'defaultRoute'        => 'site/index',
            'layout'              => '/admin/admin',
            'viewPath'            => '@Admin/views',
            'components' => [
                'errorHandler' => [
                    'class' => AdminErrorHandler::class,
                ],
            ],
        ]

    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'nWfDUaJRNtnfdgl3kWOUW8d8sEra',
            'baseUrl' => '',
        ],
        'user'       => [
            'class'           => AppHelper::getProjectComponentUserClass(),
            'identityClass'   => User::class,
            'enableAutoLogin' => true,
            'loginUrl'        => '/',
        ],
        'urlManager' => [
            'rules' => require 'url_manager_rules.php'
        ]
    ]
];

return $config_main;