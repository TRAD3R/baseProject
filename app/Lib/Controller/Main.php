<?php


namespace App\Controller;


use App\Assets\AssetHelper;

abstract class Main extends BaseController
{
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        if(!$this->getRequest()->isAjax()) {
            AssetHelper::init($this->view);
        }

        return true;
    }
}