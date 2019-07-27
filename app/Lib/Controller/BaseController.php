<?php


namespace App\Controller;


use App\App;
use yii\web\Controller;

class BaseController extends Controller
{
    private $pagination;

    public function getRequest()
    {
        return App::i()->getRequest();
    }
}