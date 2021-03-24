<?php
/**
 * @var \yii\web\View $this
 * @var AdminProfileForm $user
 */

use App\Forms\Admin\User\AdminProfileForm;
use App\Helpers\Url;
use App\Html;
use App\Models\User;
use App\Params;
use yii\widgets\ActiveForm;

$this->title = 'Редактирование пользователя ' . Html::encode($user->username);
?>
<div class="row">
    <div class="col-xs-6">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Профиль пользователя</h3>
            </div>
            <?php $form = ActiveForm::begin([
                'id'     => 'manager-form',
                'action' => Url::toRoute(['user/save-manager-profile', Params::ID => $user->id]),
                'method' => 'POST',
                'options' => [
                    'enctype' => 'multipart/form-data',
                ],
            ]); ?>
            <div class="box-body">
                <div class="col-xs-12">
                    <?= $form->field($user, 'username')->textInput(['class' => 'form-control no-toggle', 'readonly' => 'readonly', 'disabled' => 'disabled']); ?>
                    <?= $form->field($user, 'email')->textInput(['class' => 'form-control no-toggle', 'readonly' => 'readonly', 'disabled' => 'disabled']); ?>
                    <?= $form->field($user, 'type')->dropDownList(User::getUserType(), ['class' => 'form-control', 'id' => 'type']); ?>
                    <?= $form->field($user, 'status')->dropDownList(User::getStatus(), ['class' => 'form-control', 'id' => 'status']); ?>
                </div>
            </div>
            <div class="box-footer">
                <button class="btn btn-success">Сохранить</button>
            </div>
            <?php $form->end(); ?>
        </div>
    </div>
</div>

<script>
    $(function () {
        $('form').on('beforeSubmit', function () {
            var form = $(this);
            var formData = new FormData();
            var formName = '<?= $user->formName() ?>';

            formData.append(formName + '[username]', $('[name="' + formName + '[username]"]').val());
            formData.append(formName + '[email]', $('[name="' + formName + '[email]"]').val());
            formData.append(formName + '[type]', $('[name="' + formName + '[type]"]').val());
            formData.append(formName + '[status]', $('[name="' + formName + '[status]"]').val());

            $.ajax({
                url:   form.attr("action"),
                type:  form.attr("method"),
                data:  formData,
                contentType: false,
                processData: false,
                error: function () {
                    alert("Something went wrong");
                },
                success: function (response) {
                    if (response['success']) {
                        window.location.reload();
                    }
                }
            });
        }).on('submit', function (e) {
            e.preventDefault();
        });
    });
</script>


