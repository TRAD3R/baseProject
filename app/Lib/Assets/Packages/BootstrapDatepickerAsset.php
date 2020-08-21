<?php

namespace App\Assets\Packages;

use rmrevin\yii\fontawesome\cdn\AssetBundle;
use yii\bootstrap\BootstrapPluginAsset;

/**
 * Class BootstrapDatepickerAsset
 * @package App\Assets\Packages
 */
class BootstrapDatepickerAsset extends AssetBundle
{

    /** @var string */
    public $sourcePath = '@bower/bootstrap-datepicker';

    /** @var array */
    public $css = [
        'dist/css/bootstrap-datepicker3.css',
    ];

    /** @var array */
    public $js = [
        'dist/js/bootstrap-datepicker.min.js',
        'dist/locales/bootstrap-datepicker.ru.min.js',
    ];

    /** @var array */
    public $depends = [BootstrapPluginAsset::class];
}