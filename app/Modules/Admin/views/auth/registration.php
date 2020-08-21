<?php
/**
 * @var \yii\web\View                         $this
 * @var \App\Forms\Admin\User\RegistrationForm $model
 */

use yii\helpers\Html;
use \yii\bootstrap\ActiveForm;

$fieldLogin = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-user form-control-feedback'></span>"
];

$fieldEmail = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldPassword = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];

?>

<div class="login-box">

    <div class="login-box-body">
        <h1><?= $this->title ?></h1>
        <?php $form = ActiveForm::begin(['id' => 'registration-form', 'validateOnChange' => false, 'validateOnBlur' => false]); ?>
        <?= $form
            ->field($model, 'username', $fieldLogin)
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>

        <?= $form
            ->field($model, 'email', $fieldEmail)
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('email')]) ?>

        <?= $form
            ->field($model, 'password', $fieldPassword)
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

        <?= $form
            ->field($model, 'password_repeat', $fieldPassword)
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password_repeat')]) ?>

        <div class="row">
            <div class="col-xs-5">
                <?= Html::submitButton('Регистрация', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'registration-button']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>