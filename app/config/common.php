<?php

use App\Assets\Packages\BootstrapPluginAsset;
use App\Assets\Packages\JqueryAsset;
use yii\debug\Module;
use yii\web\View;

$config_common = [
    'layoutPath' => '@layouts',
    'components' => [
        'assetManager' => [
            'linkAssets' => true,
            'bundles' => [
                JqueryAsset::class => [
                    'jsOptions' => [
                        'position' => View::POS_HEAD
                    ]
                ],
                BootstrapPluginAsset::class => [
                    'jsOptions' => [
                        'position' => View::POS_HEAD
                    ]
                ]
            ]
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ]
    ]
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config_common['bootstrap'][] = 'debug';
    $config_common['modules']['debug'] = [
        'class' => Module::class,
    ];
}

return $config_common;