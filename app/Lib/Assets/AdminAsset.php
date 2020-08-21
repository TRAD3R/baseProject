<?php
namespace App\Assets;

use App\Assets\Packages\AwesomeAsset;
use App\Assets\Packages\BootstrapDatepickerAsset;
use App\Assets\Packages\AjaxSelectAsset;
use App\Assets\Packages\BootstrapFileInputAsset;
use App\Assets\Packages\HelperAsset;
use App\Assets\Packages\ICheckAsset;
use App\Assets\Packages\NotificationQueueAsset;
use Yii;
use yii\bootstrap\BootstrapAsset;
use yii\bootstrap\BootstrapPluginAsset;
use yii\web\AssetBundle;
use yii\web\YiiAsset;

class AdminAsset extends AssetBundle
{
    public $sourcePath = '@admin_resources';

    public $css = [
        'css/admin.css',
    ];
    public $js = [
//        'https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/js/transition.js',
//        'https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/js/modal.js',
//        'https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/js/tooltip.js',
//        'https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/js/popover.js',
//        'https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/js/alert.js',
//        'js/main_common.js',
        'js/app.min.js',
    ];

    public $depends = [
        YiiAsset::class,
        BootstrapAsset::class,
        AwesomeAsset::class,
        BootstrapPluginAsset::class,
        ICheckAsset::class,
        AjaxSelectAsset::class,
        BootstrapDatepickerAsset::class,
        HelperAsset::class,
        NotificationQueueAsset::class,
        BootstrapFileInputAsset::class,
    ];

    public function init()
    {
        parent::init();
        $this->css[] = 'css/skins/skin-' . Yii::$app->view->params['layout_color'] . '.min.css';
    }

}
