<?php


namespace App\Controller;

abstract class Main extends BaseController
{
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        return $this->redirect(['admin/site/index']);

//        if(!$this->getRequest()->isAjax()) {
//            AssetHelper::init($this->view);
//        }

//        return true;
    }
}