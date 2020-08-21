<?php

namespace App\Module;

use App\App;
use App\Components\AdminErrorHandler;
use Yii;

class AdminModule extends Module
{
    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();

        App::i()->setLocale('ru');

        Yii::configure($this, [
            'components' => [
                'errorHandler' => [
                    'class' => AdminErrorHandler::class,
                    'errorAction' => '/admin/error/error',
                ]
            ],
        ]);

        $handler = $this->get('errorHandler');
        Yii::$app->set('errorHandler', $handler);
        $handler->register();
    }
}