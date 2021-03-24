<?php


namespace App\Controller;

abstract class Main extends BaseController
{
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        return $this->redirect(['admin/introduce']);
    }
}