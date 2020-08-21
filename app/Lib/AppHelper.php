<?php


namespace App;


use App\Components\Trad3rWebUser;
use Yii;
use yii\base\Exception;
use yii\helpers\ArrayHelper;

/**
 * Класс для подбора параметров модулей в зависимости от стартуемого проекта.
 * Class AppHelper
 * @package App
 */
class AppHelper
{
    /**
     * @return string|null
     * @throws Exception
     */
    public static function getProjectLanguage()
    {
        $language = null;

        switch (PROJECT_ID){
            case App::PROJECT_ID_TRAD3R:
                $language = 'ru';
                break;
        }

        if(is_null($language)){
            throw new Exception(Yii::t('exception', 'NOT_FIND_BEHAVIOURS'));
        }

        return $language;
    }

    /**
     * @return string|null
     * @throws Exception
     */
    public static function getProjectComponentUserClass()
    {
        $class = null;

        switch (PROJECT_ID) {
            case App::PROJECT_ID_TRAD3R:
                $class = Trad3rWebUser::class;
                break;
        }

        if ($class === null) {
            throw new Exception('Don`t find needed behaviors');
        }

        return $class;
    }

    /**
     * @param $module
     * @return string|null
     * @throws Exception
     */
    public static function getProjectControllerNamespace($module)
    {
        $namespace_map = [
            App::CONFIG_MODULE_MAIN => [
                App::PROJECT_ID_TRAD3R => 'Main\Trad3r\Controllers',
            ],
            App::CONFIG_MODULE_CONSOLE => [
                App::PROJECT_ID_TRAD3R => 'Console\Trad3r\Controllers'
            ]
        ];

            $controller_namespace = ArrayHelper::getValue($namespace_map, [$module, PROJECT_ID]);

        if(is_null($controller_namespace)){
            throw new Exception(Yii::t('exception', 'NOT_FIND_BEHAVIOURS'));
        }

        return $controller_namespace;
    }

    /**
     * @return string|null
     * @throws Exception
     */
    public static function getProjectLayout()
    {
        $layout = null;

        switch (PROJECT_ID){
            case App::PROJECT_ID_TRAD3R:
                $layout = 'main/trad3r/layout';
                break;
        }

        if(is_null($layout)){
            throw new Exception(Yii::t('exception', 'NOT_FIND_BEHAVIOURS'));
        }

        return $layout;
    }

    /**
     * @return string|null
     * @throws Exception
     */
    public static function getProjectResourcesAlias()
    {
        $alias = null;

        switch (PROJECT_ID){
            case App::PROJECT_ID_TRAD3R:
                $alias = '@trad3r_resources';
                break;
        }

        if(is_null($alias)){
            throw new Exception(Yii::t('exception', 'NOT_FIND_BEHAVIOURS'));
        }

        return $alias;
    }

    /**
     * @return string|null
     * @throws Exception
     */
    public static function getProjectParamsFile()
    {
        $params_file = null;

        switch (PROJECT_ID) {
            case App::PROJECT_ID_TRAD3R:
                $params_file = 'trad3r_params.php';
                break;
        }

        if ($params_file === null) {
            throw new Exception('Don`t find needed behaviors');
        }

        return $params_file;
    }

    /**
     * @return string|null
     * @throws Exception
     */
    public static function getProjectErrorViewPath()
    {
        $view_path = null;

        switch (PROJECT_ID) {
            case App::PROJECT_ID_TRAD3R:
                $view_path = '/trad3r';
                break;
        }

        if ($view_path === null) {
            throw new Exception('Don`t find needed behaviors');
        }

        $view_path = '@layouts/error/' . $view_path;

        return $view_path;
    }
}