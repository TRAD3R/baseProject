﻿1) Содержимое файла codeception.yml
   ```
    paths:
        tests: tests
        output: tests/_output
        data: tests/_data
        support: tests/_support
        envs: tests/_envs
    actor_suffix: Tester
    extensions:
        enabled:
            - Codeception\Extension\RunFailed
    bootstrap: _bootstrap.php
   ```
2) Содержимое файла *tests/_bootstap.php*
   ```
    define('YII_ENV', 'test');
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    require_once dirname(__DIR__) . '/vendor/yiisoft/yii2/Yii.php';
    require dirname(__DIR__) . '/vendor/autoload.php';
    require (dirname(__DIR__) . '/app/config/bootstrap.php');
    defined("PROJECT_ID") or define("PROJECT_ID", \App\	App::PROJECT_ID_TRAD3R);
    defined("BASE_PATH") or define("BASE_PATH", dirname(__DIR__) . '/app/Modules/Main/Trad3r');
   ```
3) В каждой папке с тестами лежит пустой *_bootstrap.php*
4) acceptance.suite.yml:
   ```
   actor: AcceptanceTester
   modules:
       enabled:
       #        - PhpBrowser:
       #          url: http://cha.trd
           - \Helper\Acceptance
           - Yii2:
               configFile: 'tests/_config/acceptance.php'
               part: [orm, fixtures] # allow to use AR methods
               entryScript: index.php
           - WebDriver:
               url: http://cha.trd
               browser: chrome
               restart: true
               window_size: 1024x768
          step_decorators: ~
   ```
5) Установка *Selenium*
   > composer require se/selenium-server-standalone
6) Установка и настройка драйверов для работы selenium <https://losst.ru/ustanovka-selenium-v-linux>
7) Запуск selenium
   > vendor/bin/selenium-server-standalone
8) добавить алиас:
   > alias codecept='/vendor/bin/codecept'
9) сгенерировать недостающие файлы (tests\_support\_generated):
   > codecept build
10) создать тест:
   > codecept g:cept acceptance ИМЯТЕСТА

   или

    > codecept g:test unit ИМЯТЕСТАTest

11) Запуск тестов:
    > codecept run unit  ИМЯТЕСТАTest
