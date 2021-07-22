<?php
/**
 * @var \yii\web\View                        $this
 * @var \App\Forms\Admin\User\LoginAdminForm $model
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<div class="login-box">
    <div class="login-box-body">
        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>

        <?= $form
            ->field($model, 'username')
            ->label(false)
            ->textInput() ?>

        <?= $form
            ->field($model, 'password')
            ->label(false)
            ->passwordInput() ?>

        <div class="row">
            <div class="col-xs-4">
                <?= Html::submitButton('<i class="fas fa-sign-in-alt"></i>', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass   : 'iradio_square-blue',
            increaseArea : '20%' // optional
        });
    });
</script>

<style>
    .radio label, .checkbox label {
        cursor: pointer;
        font-weight: normal;
        margin-bottom: 0;
        min-height: 20px;
        padding-left: 0;
    }
</style>
