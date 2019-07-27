<?php
// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');
defined("BASE_PATH") or define("BASE_PATH", dirname(__DIR__) . '/app/Modules/Main/Trad3r');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';
require (dirname(__DIR__) . '/app/config/bootstrap.php');

defined("PROJECT_ID") or define("PROJECT_ID", \App\App::PROJECT_ID_TRAD3R);

//$config = require __DIR__ . '/../config/web.php';
$config = \App\App::i()->buildConfig(\App\App::CONFIG_MODULE_MAIN);

(new yii\web\Application($config))->run();
