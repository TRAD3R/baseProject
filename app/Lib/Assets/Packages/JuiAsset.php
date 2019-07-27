<?php


namespace App\Assets\Packages;


use yii\web\AssetBundle;

class JuiAsset extends AssetBundle
{
    public $sourcePath = '@bower/jquery-ui';

    public $js = [
        'jquery-ui.js'
    ];

    public $depends = [
        JqueryAsset::class
    ];
}