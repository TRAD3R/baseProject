<?php

namespace Admin\Controllers;

use App\App;
use App\Assets\AdminAsset;
use App\Controller\BaseController;
use yii\base\Exception;
use yii\base\UserException;
use yii\web\HttpException;

class ErrorController extends BaseController  {

    public $layout = '/error';

    public function beforeAction($action)
    {
        AdminAsset::register($this->view);
        return parent::beforeAction($action);
    }

    public function actionError() {
        if (($exception = \Yii::$app->getErrorHandler()->exception) === null) {
            // action has been invoked not from error handler, but by direct route, so we display '404 Not Found'
            $exception = new HttpException(404, \Yii::t('yii', 'Page not found.'));
        }

        if ($exception instanceof HttpException) {
            $code = $exception->statusCode;
        } else {
            $code = $exception->getCode();
        }

        if ($exception instanceof Exception) {
            $name = $exception->getName();
        } else {
            $name = \Yii::t('yii', 'Error');
        }
        if ($code) {
            $name .= " (#$code)";
        }

        if ($exception instanceof UserException) {
            $message = $exception->getMessage();
        } else {
            $message = \Yii::t('yii', 'An internal server error occurred.');
        }

        if (!in_array((int)$code, [404, 403, 500])) {
            $code = 500;
        }

        if (\Yii::$app->getRequest()->getIsAjax()) {
            return "$name: $message";
        } else {
            $this->view->title = $name;

            return $this->render($code);
        }

    }


}