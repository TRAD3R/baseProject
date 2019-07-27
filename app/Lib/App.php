<?php


namespace App;

use App\Config\Config;
use App\Config\ConfigManager;
use yii\helpers\ArrayHelper;
use App\Request;

class App
{
    use Singleton;
    const CONFIG_MODULE_CONSOLE = 'console';
    const CONFIG_MODULE_MAIN = 'main';

    const PROJECT_ID_TRAD3R = 1;

    const PROJECT_LANGUAGE_RU = 'ru';

    /**
     * @var array
     */
    private $config;

    /**
     * @var Config
     */
    private $param_config;

    /**
     * @throws \yii\base\Exception
     */
    public function init()
    {
        $this->param_config = (new ConfigManager(PROJECT_ID))->getConfig();
    }

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this->param_config;
    }

    public function buildConfig($module_name)
    {
        if(empty($this->config[$module_name])){
            $app_config = require(dirname(__DIR__) . '/config/config.php');
            $project_config = $module_config = $common_config = $local_config = [];
            if($this->isTrad3r()){
                $project_config_file = dirname(__DIR__) . '/config/trad3r.php';
            }
            if(isset($project_config_file) && is_file($project_config_file) && is_readable($project_config_file)){
                $project_config = require $project_config_file;
            }

            $config_file_module = dirname(__DIR__) . '/config/modules/' . $module_name . '.php';
            if(is_file($config_file_module) && is_readable($config_file_module)){
                $module_config = require $config_file_module;
            }

            $config_file_common = dirname(__DIR__) . '/config/common.php';
            if(is_file($config_file_common) && is_readable($config_file_common)) {
                $common_config = require $config_file_common;
            }

            if($this->isTrad3r()){
                $config_file_local = dirname(__DIR__) . '/config/config_local_trad3r.php';
            }
            if(isset($config_file_local) && is_file($config_file_local) && is_readable($config_file_local)){
                $local_config = require $config_file_local;
            }

            $this->config[$module_name] = ArrayHelper::merge($app_config, $project_config, $module_config, $common_config, $local_config);
        }

        return $this->config[$module_name];
    }

    public function isTrad3r()
    {
        return PROJECT_ID === self::PROJECT_ID_TRAD3R;
    }

    public function getRequest()
    {
        /** @var Request $request */
        $request = \Yii::$container->get(Request::class, [], ['request' => \Yii::$app->request]);

        return $request;
    }

    /**
     * @return \yii\console\Controller|\yii\web\Controller
     */
    public function getController()
    {
        return \Yii::$app->controller;
    }
}