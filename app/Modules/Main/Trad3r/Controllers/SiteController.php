<?php


namespace Main\Trad3r\Controllers;


use App\Controller\Main;

class SiteController extends Main
{
    public function actionIndex()
    {
        $this->view->title = 'Trad3r';
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => 'Trad3r - популярная настольная карточная игра'
        ]);
        $this->view->registerMetaTag([
            'name' => 'keyword',
            'content' => 'Trad3r, карточная игра, настольная игра, Бэнг'
        ]);

        return $this->render('index');
    }
}