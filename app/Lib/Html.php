<?php

namespace App;

use App\Helpers\Url;
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

        return $view->renderFile('@Admin/views/layout/paginator.php', ['pagination' => $pagination, 'options' => $options]);
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

    /**
     * Генерим ссылку на юзера
     * @param        $id
     * @param string $target
     * @param bool   $use_icon
     * @param string $field
     * @return string
     */
    public static function userUrl($id, $target = '_blank', $use_icon = true, $field = null)
    {
        if (!$field) {
            $field = $id;
        }

        return '<a href="' . Url::toRoute([
                'user/edit',
                Params::ID => $id,
            ]) . '" target="' . $target . '">' . ($use_icon ? '<i class="fa fa-user"></i>&nbsp;' : '') . self::encode($field) . '</a>';
    }
}