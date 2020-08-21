<?php

namespace App\Assets\Packages;

use rmrevin\yii\fontawesome\cdn\AssetBundle;
use yii\bootstrap\BootstrapPluginAsset;

/**
 * Class BootstrapFileInputAsset
 * @package App\Assets\Packages
 */
class BootstrapFileInputAsset extends AssetBundle
{
    /** @var string */
    public $sourcePath = '@packages/bootstrap.file.input';

    /** @var array */
    public $js = [
        'js/bootstrap.file.input.js',
    ];

    /** @var array */
    public $depends = [BootstrapPluginAsset::class];
}