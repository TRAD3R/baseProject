<?php
/**
 * @var \yii\web\View                  $this
 * @var \App\Forms\Admin\User\ChangePasswordForm $model
 */

use App\Html;
use yii\bootstrap\ActiveForm;

$fieldPassword = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='fa fa-lock form-control-feedback'></span>"
];

$fieldError = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => ""
];
?>

<div class="login-box">
    <div class="login-logo">Reset Password</div>
    <div class="login-box-body">
        <div class="box-title text-center">
            <h3>Enter new password</h3>
        </div>
        <?php $form = ActiveForm::begin(['id' => 'reset-password-form', 'validateOnChange' => false, 'validateOnBlur' => false]); ?>

        <?= $form
            ->field($model, 'password', $fieldPassword)
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

        <?= $form
            ->field($model, 'password_repeat', $fieldPassword)
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password_repeat')]) ?>

        <div class="row">
            <div class="col-xs-offset-8 col-xs-4">
                <?= Html::submitButton('Set', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'reset-password-button']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>