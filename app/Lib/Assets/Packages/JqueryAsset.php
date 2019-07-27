<?php


namespace App\Assets\Packages;

use yii\web\AssetBundle;

class JqueryAsset extends AssetBundle
{
    public $sourcePath = '@bower/jquery/dist';
    public $js = [
        'jquery.js'
    ];
}