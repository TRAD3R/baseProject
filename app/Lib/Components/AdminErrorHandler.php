<?php

namespace App\Components;

use App\App;
use yii\web\ErrorHandler;

class AdminErrorHandler extends ErrorHandler
{
    public function renderException($exception)
    {
        $current_user = App::i()->getCurrentUser();

        if (!$current_user || ($current_user && !$current_user->isAdmin())) {
            $this->errorAction = '/admin/error/error';
            $this->exception = $exception;
        }

        parent::renderException($exception);
    }
}