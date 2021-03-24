<?php
/**
 * User: vishnyakov
 * Date: 28.11.17
 * @var CreateForm $user
 */

use App\Forms\Admin\User\CreateForm;
use App\Helpers\Url;
use App\Models\User;
use yii\widgets\ActiveForm;

?>
<div class="row">
    <div class="col-xs-4">
        <div class="box box-success">
            <div class="box-body">
                <?php $form = ActiveForm::begin([
                    'id'                     => 'create-form',
                    'validateOnChange'       => false,
                    'validateOnBlur'         => false,
                    'enableAjaxValidation'   => false,
                    'enableClientValidation' => false,
                    'action'                 => Url::toRoute('user/add'),
                ]); ?>
                <?= $form->field($user, 'username')->textInput(['class' => 'form-control']); ?>
                <label> <a href="javascript:void(0);" class="generate-btn">Пароль</a> <span class="generate" style="font-weight: normal;"></span></label>
                <?= $form->field($user, 'password')->passwordInput(['class' => 'form-control'])->label(false); ?>

                <?= $form->field($user, 'password_repeat')->passwordInput(['class' => 'form-control']); ?>
                <?= $form->field($user, 'email')->textInput(['class' => 'form-control']); ?>
                <?= $form->field($user, 'type')->dropDownList(User::getUserType(), ['class' => 'form-control', 'id' => 'type']); ?>
            </div>
            <div class="box-footer">
                <button class="btn btn-success">Добавить</button>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<script>
    $(function () {
        $('.generate-btn').on('click', function() {
            $('.generate').text(Math.random().toString(36).slice(-8)+''+Math.random().toString(36).slice(-8));
        });
    });
</script>

