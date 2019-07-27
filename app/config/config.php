<?php

use App\AppHelper;

$params = require AppHelper::getProjectParamsFile();

$config = [
    'language' => AppHelper::getProjectLanguage(),
    'bootstrap' => ['log'],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'basePath' => BASE_PATH,
    'components' => [
        'i18n' => [
            'translations' => [
                'exception' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    // каталог, где будут располагаться словари
                    'basePath' => '@translates',
                    // исходный язык, на котором изначально написаны фразы в приложении
                    'sourceLanguage' => 'en',
                ],
                'front' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    // каталог, где будут располагаться словари
                    'basePath' => '@translates',
                    // исходный язык, на котором изначально написаны фразы в приложении
                    'sourceLanguage' => 'en',
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