<?php


namespace App\Assets\Packages\Trad3r;


use yii\web\AssetBundle;

class MainAsset extends AssetBundle
{
    public $sourcePath = '@trad3r_resources';
    public $css = [
        'css/main.css'
    ];

    public $depends = [
        CommonTrad3rAssets::class
    ];
}