<?php

$config_common = [
    'layoutPath' => '@layouts',
    'components' => [
        'assetManager' => [
            'linkAssets' => true,
            'bundles' => [
                \App\Assets\Packages\JqueryAsset::class => [
                    'jsOptions' => [
                        'position' => \yii\web\View::POS_HEAD
                    ]
                ],
                \App\Assets\Packages\BootstrapPluginAsset::class => [
                    'jsOptions' => [
                        'position' => \yii\web\View::POS_HEAD
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
        'class' => \yii\debug\Module::class,
    ];
}

return $config_common;