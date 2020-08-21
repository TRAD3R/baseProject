<?php

namespace App\Assets\Packages;

use yii\web\AssetBundle;

/**
 * Class AwesomeAsset
 * @package App\Assets\Packages
 */
class AwesomeAsset extends AssetBundle {

    /** @var string */
    public $sourcePath = '@bower/fontawesome';

    /** @var array */
    public $css = [
        'css/font-awesome.min.css',
    ];

}