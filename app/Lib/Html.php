<?php

namespace App;

use Exception;
use yii\data\Pagination;
use yii\web\View;

class Html extends \yii\helpers\Html
{

    /**
     * Вставляем во вьюху в то место, где нужен пагинатор
     * @see OfferController
     * @param View       $view
     * @param Pagination $pagination
     * @param array      $options
     * @return string
     * @throws \Exception
     */
    public static function pagination(View $view, Pagination $pagination, $options = [])
    {
        if (!$view || !$pagination) {
            throw new Exception('Invalid params passed');
        }

        return $view->renderFile('@Admin/views/layouts/paginator.php', ['pagination' => $pagination, 'options' => $options]);
    }

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public static function getCsrfField()
    {
        return \yii\helpers\Html::hiddenInput(App::i()->getRequest()->getCsrfParam(), App::i()->getRequest()->getCsrf());
    }
}