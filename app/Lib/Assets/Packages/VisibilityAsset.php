<?php

namespace App\Assets\Packages;

use yii\web\AssetBundle;

/**
 * Class VisibilityAsset
 * @package App\Assets\Packages
 */
class VisibilityAsset extends AssetBundle
{

    /** @var string */
    public $sourcePath = '@bower/visibilityjs';

    /** @var array */
    public $js         = [
        'lib/visibility.core.js',
        'lib/visibility.fallback.js',
        'lib/visibility.timers.js',
    ];
}