<?php

use App\AppHelper;
use App\RBAC\AuthManager;

$params = require AppHelper::getProjectParamsFile();

$config = [
    'language' => AppHelper::getProjectLanguage(),
    'bootstrap' => ['log'],
    'vendorPath' => dirname(__DIR__, 2) . '/vendor',
    'basePath' => BASE_PATH,
    'components' => [
        'authManager' => [
            'class' => AuthManager::class,
        ],
        'i18n' => [
            'translations' => [
                'exception' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    // каталог, где будут располагаться словари
                    'basePath' => '@translates',
                    // исходный язык, на котором изначально написаны фразы в приложении
                    'sourceLanguage' => 'snake',
                ],
                'front' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    // каталог, где будут располагаться словари
                    'basePath' => '@translates',
                    // исходный язык, на котором изначально написаны фразы в приложении
                    'sourceLanguage' => 'snake',
                ],
                'admin' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    // каталог, где будут располагаться словари
                    'basePath' => '@translates',
                    // исходный язык, на котором изначально написаны фразы в приложении
                    'sourceLanguage' => 'snake',
                ],
            ],
        ],
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ]
];

return $config;