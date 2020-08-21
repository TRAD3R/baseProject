<?php

namespace App\Assets\Packages;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class AjaxSelectAsset extends AssetBundle
{

    /** @var string */
    public $sourcePath = '@packages/ajax-select';

    /** @var array */
    public $js = [
        'js/select2.js',
        'js/select-ajax.js',
    ];

    /** @var array */
    public $css = [
        'css/select2.min.css',
    ];

    /** @var array */
    public $depends = [
        JqueryAsset::class,
    ];
}