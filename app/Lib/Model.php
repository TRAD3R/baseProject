<?php

namespace App;

abstract class Model extends \yii\base\Model {

    public $isNewRecord = true;

    /** @var  ActiveRecord */
    public $_entity = false;

    /**
     * @param ActiveRecord|null $activeRecord
     */
    public function __construct(ActiveRecord $activeRecord = null)
    {
        if ($activeRecord) {
            $this->_entity = $activeRecord;
            $this->isNewRecord = $this->_entity->isNewRecord;
        }
        parent::__construct();
    }

    /**
     * Разбиваем входящие данные по любому из разделителей
     * @param $data
     * @return array|false|string[]
     */
    public function getExplodedData($data)
    {
        $data = preg_split('/[,\n\s\r\n]/', $data);
        $data = array_map('trim', $data);
        $data = array_filter($data, function ($kw) {
            return $kw !== '';
        });

        return $data;
    }
}