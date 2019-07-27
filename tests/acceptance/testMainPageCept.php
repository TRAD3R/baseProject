<?php

/** @var Codeception\Scenario $scenario */

$I = new AcceptanceTester($scenario);
$I->wantTo('Проверяю работу главной страницы');
$I->amOnPage(\yii\helpers\Url::home());
$I->see('Start page');