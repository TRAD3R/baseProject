<?php

namespace App\Assets\Packages;

use yii\web\AssetBundle;

/**
 * Class HelperAsset
 * @package App\Assets\Packages
 */
class HelperAsset extends AssetBundle
{

    /** @var string */
    public $sourcePath = '@packages/helper';

    /** @var array */
    public $js = [
        'js/helper.js',
    ];
}