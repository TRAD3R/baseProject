<?php


namespace App;

use App\Config\Config;
use App\Config\ConfigManager;
use App\Models\User;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

class App
{
    use Singleton;
    const CONFIG_MODULE_CONSOLE = 'console';
    const CONFIG_MODULE_MAIN    = 'main';
    const CONFIG_MODULE_ADMIN   = 'admin';


    const PROJECT_ID_TRAD3R = 1;

    const PROJECT_LANGUAGE_RU = 'ru';
    const PROJECT_LANGUAGE_EN = 'en';

    const LOG_DEV = 'dev';

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
     * @return \yii\console\Application|\yii\web\Application
     */
    public function getApp()
    {
        return Yii::$app;
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

            if (!in_array($module_name, [App::CONFIG_MODULE_CONSOLE])) {
                $config_file_common = dirname(__DIR__) . '/config/common.php';
                if (is_file($config_file_common) && is_readable($config_file_common)) {
                    $common_config = require($config_file_common);
                }
            }

            if($this->isTrad3r()){
                $config_file_local = dirname(__DIR__) . '/config/trad3r_local.php';
            }
            if(isset($config_file_local) && is_file($config_file_local) && is_readable($config_file_local)){
                $local_config = require $config_file_local;
            }

            $this->config[$module_name] = ArrayHelper::merge($app_config, $project_config, $module_config, $common_config, $local_config);
        }

        return $this->config[$module_name];
    }

    /**
     * @return null|User|IdentityInterface
     */
    public function getCurrentUser()
    {
        return Yii::$app->user->identity;
    }

    public function isTrad3r()
    {
        return PROJECT_ID === self::PROJECT_ID_TRAD3R;
    }

    public function getRequest()
    {
        /** @var Request $request */
        $request = Yii::$container->get(Request::class, [], ['request' => Yii::$app->request]);

        return $request;
    }

    /**
     * @return Response
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public function getResponse()
    {
        /** @var Response $response */
        $response = Yii::$container->get(Response::class, [], ['response' => Yii::$app->response]);

        return $response;
    }


    /**
     * @return \yii\console\Controller|\yii\web\Controller
     */
    public function getController()
    {
        return Yii::$app->controller;
    }

    /**
     * @return \yii\db\Connection
     */
    public function getDb()
    {
        return Yii::$app->db;
    }

    /**
     * @return Cookie
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public function getCookie()
    {
        /** @var Cookie $cookie */
        $cookie = Yii::$container->get(
            Cookie::class,
            [],
            [
                'cookieResponse' => Yii::$app->response->cookies,
                'cookieRequest' => Yii::$app->request->cookies
            ]
        );

        return $cookie;
    }

    /**
     * @return \yii\web\Session
     */
    public function getSession()
    {
        return Yii::$app->getSession();
    }

    /**
     * @return File
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public function getFile()
    {
        /** @var File $file */
        $file = Yii::$container->get(File::class);

        return $file;
    }


    public function setLocale($language)
    {
        switch ($language) {
            case self::PROJECT_LANGUAGE_RU:
                $domain = 'ru-RU';
                break;
            default:
                $domain = 'en-US';
                break;
        }
        putenv('LANG=' . $domain);
        setlocale(LC_MESSAGES, $domain . '.utf8');
        bindtextdomain($domain, dirname(__DIR__, 2) . '/locale');
        textdomain($domain);
        bind_textdomain_codeset($domain, 'UTF-8');
    }

}