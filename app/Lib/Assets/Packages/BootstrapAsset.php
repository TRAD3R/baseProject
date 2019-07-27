<?php


namespace App\Assets\Packages;


use yii\web\AssetBundle;

class BootstrapAsset extends AssetBundle
{
    public $sourcePath = '@bower/bootstrap/dist';
    public $css = [
        'css/bootstrap.css'
    ];
}