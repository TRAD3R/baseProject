<?php

namespace Admin\Controllers;

use App\Controller\Admin;
use App\Models\User;
use yii\db\Expression;
use yii\db\Query;

class SiteController extends Admin
{
    public function actionIndex()
    {
        $this->view->title = '';

        $params = $this->getCommonData();

        return $this->render('index', [
            'params' => $params,
        ]);
    }

    protected function getCommonData()
    {
        $data = [];

        $data['users'] = (new Query())
            ->select([
                'user_total'     => new Expression('SUM(IF(type = ' . User::TYPE_USER . ', 1, 0))'),
            ])
            ->from(User::tableName())
            ->one();

        return $data;
    }
}
