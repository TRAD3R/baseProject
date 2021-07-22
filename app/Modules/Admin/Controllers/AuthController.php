<?php

namespace Admin\Controllers;

use App\Controller\Admin;
use App\Forms\Admin\User\LoginAdminForm;
use Yii;
use yii\filters\AccessControl;

class AuthController extends Admin
{
    public $layout = '/admin/auth';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only'  => ['logout'],
                'rules' => [
                    [
                        'allow'   => true,
                        'roles'   => ['@']
                    ],
                    [
                        'actions' => ['login'],
                        'allow'   => true,
                        'roles'   => ['?'],
                    ],
                ],
            ],
        ];
    }

    public function actionLogin()
    {
        $this->view->title = 'Вход в систему';
        $this->view->registerMetaTag([
            'name'    => 'robots',
            'content' => 'noindex, nofollow'
        ]);

        $model = new LoginAdminForm();
        if ($model->load($this->getRequest()->post()) && $model->login()) {
            return $this->getResponse()->redirect(['admin/site/index']);
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->getResponse()->redirect(['admin/introduce']);
    }

}