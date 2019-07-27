<?php

use App\AppHelper;

$params = require AppHelper::getProjectParamsFile();

$config = [
    'language' => AppHelper::getProjectLanguage(),
    'bootstrap' => ['log'],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'basePath' => BASE_PATH,
    'components' => [

    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ]
];

return $config;