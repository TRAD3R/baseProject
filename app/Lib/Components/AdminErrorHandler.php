<?php

namespace App\Components;

use App\App;
use yii\web\ErrorHandler;
use yii\web\NotFoundHttpException;

class AdminErrorHandler extends ErrorHandler
{
    public function renderException($exception)
    {
        $current_user = App::i()->getCurrentUser();

        if (!$current_user || ($current_user && !$current_user->isAdmin())) {
            $this->errorAction = '/error/error';
            $this->exception = new NotFoundHttpException();
        }

        parent::renderException($exception);
    }
}