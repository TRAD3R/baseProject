<?php

namespace App\Assets\Packages;

use yii\web\AssetBundle;

/**
 * Class GritterAsset
 * @package App\Assets\Packages
 */
class GritterAsset extends AssetBundle
{

    /** @var string */
    public $sourcePath = '@bower/gritter';

    /** @var array */
    public $css        = [
        'css/jquery.gritter.css',
    ];

    /** @var array */
    public $js         = [
        'js/jquery.gritter.min.js',
    ];
}