<?php
/**
 * @var \App\Forms\Admin\User\ChangePasswordForm $model
 */
?>
<div class="box box-success">
    <div class="box-body">
        <?php

        use App\Helpers\Url;
        use App\Html;
        use App\Params;
        use yii\widgets\ActiveForm;

        $form = ActiveForm::begin(['id' => 'security-form', 'action' => Url::toRoute(['/admin/user/change-password', Params::ID => $model->id])]);
        ?>
        <div class="inner-gray">
            <div class="form-group">
                <a href="javascript:void(0);" class="generate-btn">Сгенерировать пароль</a> <span class="generate" style="font-weight: normal;"></span>
            </div>
            <div class="form-group <?= $model->hasErrors('password') ? 'has-error' : ''; ?>">
                <?= Html::activePasswordInput($model, 'password', ['class' => 'form-control', 'placeholder' => 'Новый пароль']); ?>
                <?php if ($model->hasErrors('password')) : ?>
                    <?= Html::error($model, 'password', ['tag' => 'p', 'class' => 'help-block']); ?>
                <?php endif; ?>
            </div>
            <div class="form-group <?= $model->hasErrors('password_repeat') ? 'has-error' : ''; ?>">
                <?= Html::activePasswordInput($model, 'password_repeat', ['class' => 'form-control', 'placeholder' => 'Повторите новый пароль']); ?>

                <?php if ($model->hasErrors('password_repeat')) : ?>
                    <?= Html::error($model, 'password_repeat', ['tag' => 'p', 'class' => 'help-block']); ?>
                <?php endif; ?>
            </div>
            <div class="submit">
                <button class="btn btn-success">Сохранить</button>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    <div class="box-footer"></div>
</div>
<script>
    $(function() {
        $('.generate-btn').on('click', function() {
            $('.generate').text(Math.random().toString(36).slice(-8)+''+Math.random().toString(36).slice(-8));
        });
    });
</script>