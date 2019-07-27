<?php


namespace Console\Trad3r\Controllers;


use App\Console\Tools\Resources;
use yii\console\Controller;

class ResourcesController extends Controller
{
    public function actionIndex()
    {
        (new Resources())->run();
    }
}