<?php

namespace App\Assets\Packages;

use rmrevin\yii\fontawesome\cdn\AssetBundle;
use yii\web\JqueryAsset;

class ICheckAsset extends AssetBundle
{

    /** @var string */
    public $sourcePath = '@bower/icheck';

    /** @var array */
    public $css = [
        'skins/square/blue.css',
    ];

    /** @var array */
    public $js      = [
        'icheck.min.js',
    ];

    /** @var string */
    public $depends = [JqueryAsset::class];
}