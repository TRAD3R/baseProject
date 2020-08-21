<?php
define('YII_ENV', 'test');
defined('YII_DEBUG') or define('YII_DEBUG', true);

require_once dirname(__DIR__) . '/vendor/yiisoft/yii2/Yii.php';
require dirname(__DIR__) . '/vendor/autoload.php';
require (dirname(__DIR__) . '/app/config/bootstrap.php');
defined("PROJECT_ID") or define("PROJECT_ID", \App\App::PROJECT_ID_TRAD3R);
defined("BASE_PATH") or define("BASE_PATH", dirname(__DIR__) . '/app/Modules/Main/Trad3r');