<?php


namespace App\Assets;

use App\App;
use yii\web\AssetBundle;
use yii\web\View;

/**
 * Класс для работы с ассетсами модулей: main
 * Регистрируется в beforeAction главного контроллера модуля (@see \App\Controller\Publisher)
 * Class AssetHelper
 * @package App\Assets
 */
class AssetHelper
{
    /** @var string все экшены контроллера */
    const CONTROLLER_ALL = 'controller_all';
    const COMMON_PART = 'common';
    const BUNDLES = 'bundles';
    const CONTROLLERS = 'controllers';
    const CSS = 'css';

    public static function init(View $view)
    {
        $config = App::i()->getConfig()->getClientScriptConfig();

        /**
         *  Регистрируем ассеты, которые нужны для всех модулей
         */
        if(!empty($config[self::COMMON_PART])){
            /** @var AssetBundle[] $asset_classes */
            $asset_classes = $config[self::COMMON_PART];

            foreach ($asset_classes as $asset_class) {
                $asset_class::register($view);
            }
        }

        $module_config = $config[App::i()->getController()->module->id];

        /** регистрируем общие пакеты для всего модуля */
        if(!empty($module_config[self::BUNDLES])){
            /** @var AssetBundle[] $asset_classes */
            $asset_classes = $module_config[self::BUNDLES];

            foreach ($asset_classes as $asset_class){
                $asset_class::register($view);
            }
        }

        $controller_config = $config[App::i()->getController()->module->id][self::CONTROLLERS][App::i()->getController()->id];

        if (!empty($controller_config)){
            /** регистрируем данные файлов для экшенов контроллера */
            if(!empty($controller_config[self::CONTROLLER_ALL][self::BUNDLES])){
                /** @var AssetBundle[] $asset_classes */
                $asset_classes = $controller_config[self::CONTROLLER_ALL][self::BUNDLES];

                foreach ($asset_classes as $asset_class){
                    $asset_class::register($view);
                }
            }

            if(!empty($controller_config[self::CONTROLLER_ALL][self::CSS])){
                foreach ($controller_config[self::CONTROLLER_ALL][self::CSS] as $css){
                    $view->registerCss($css);
                }
            }

            /** регистрируем данные для определенного экшена контроллера */
            if(!empty($controller_config[App::i()->getController()->action->id])){
                if(!empty($controller_config[App::i()->getController()->action->id][self::BUNDLES])){
                    /** @var AssetBundle[] $asset_classes */
                    $asset_classes = $controller_config[App::i()->getController()->action->id][self::BUNDLES];

                    foreach ($asset_classes as $asset_class){
                        $asset_class::register($view);
                    }
                }

                if(!empty($controller_config[App::i()->getController()->action->id][self::CSS])){
                    /** @var AssetBundle[] $asset_classes */
                    $asset_classes = $controller_config[App::i()->getController()->action->id][self::CSS];

                    foreach ($asset_classes as $asset_class){
                        $asset_class::register($view);
                    }
                }
            }
        }

    }
}