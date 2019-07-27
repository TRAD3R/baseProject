<?php


namespace App\Config;


use App\App;
use Yii;
use yii\base\Exception;

class ConfigManager
{
    protected $config_instance = null;

    /**
     * ConfigManager constructor.
     * @param int $project_id
     * @throws Exception
     */
    public function __construct($project_id)
    {
        switch ($project_id){
            case App::PROJECT_ID_TRAD3R:
                $this->config_instance = new Trad3rConfig();
                break;
            default:
                throw new Exception(Yii::t('exception', 'CONFIG_NOT_FOUND'));
        }
    }

    /**
     * @return Trad3rConfig|null
     * @throws Exception
     */
    public function getConfig()
    {
        if(is_null($this->config_instance)){
            throw new Exception(Yii::t('exception', 'CONFIG_NOT_FOUND'));
        }
        return $this->config_instance;
    }

}