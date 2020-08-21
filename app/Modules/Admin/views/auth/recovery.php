<?php
/**
 * @var \yii\web\View                  $this
 * @var \App\Forms\Admin\User\RecoveryPasswordForm $recovery_form
 */

use App\Html;
use yii\bootstrap\ActiveForm;

$fieldEmail = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='fa fa-email form-control-feedback'></span>"
];

$fieldError = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => ""
];
?>

<div class="login-box">
    <div class="login-logo">Recovery password</div>
    <div class="login-box-body">
        <div class="box-title text-center">
            <h4>Send recovery mail</h4>
        </div>
        <?php $form = ActiveForm::begin(['id' => 'login-form', 'validateOnChange' => false, 'validateOnBlur' => false]); ?>

        <?= $form
            ->field($recovery_form, 'email', $fieldEmail)
            ->label(false)
            ->textInput(['placeholder' => $recovery_form->getAttributeLabel('email')]) ?>

        <div class="row">
            <div class="col-xs-offset-8 col-xs-4">
                <?= Html::submitButton('Send', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'recovery-button']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>