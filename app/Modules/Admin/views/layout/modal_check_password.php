<?php

use App\App;
use App\Helpers\Url;
use App\Html;
use App\Roles;

?>

<div class="modal fade" tabindex="-1" role="dialog" id="check-manager-password-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span><span class="sr-only">Закрыть</span></button>
                <h2 class="modal-title">Подтверждение действия</h2>
            </div>
            <div class="modal-body" style="height: 130px;">
                <div class="inner">
                    <?= Html::beginForm(Url::toRoute('user/check-manager-password'), 'post', array('id' => 'check-manager-password-form')); ?>
                    <div class="form-group  col-xs-12" id="check_password">
                        <p>Введите пароль</p>
                        <?= Html::passwordInput('manager-password', '', array('class' => 'form-control', 'required' => 'required', 'autocomplete' => 'off')); ?>
                        <span class="errorMessage"></span>
                    </div>
                    <?= Html::endForm(); ?>
                </div>
            </div>
            <div class="modal-footer">
                <?= Html::submitButton('Отправить', [
                    'class' => 'btn btn-success',
                    'id'    => 'submit-manager-password'
                ]) ?>
                <button type="button" class="btn btn-default" data-dismiss="modal">Отменить</button>
            </div>
        </div>
    </div>
</div>

<script>
    var CheckManagerAction = {
        form: null,
        modal: null,
        is_check_password: <?= (int)Roles::i()->isAdministrator(App::i()->getCurrentUser()); ?>,
        event_obj: '',
        event: '',
        init: function () {
            CheckManagerAction.form = $('#check-manager-password-form');
            CheckManagerAction.modal = $('#check-manager-password-modal');
            $('[data-check-manager-password="1"]').on('click', function (event) {
                if (CheckManagerAction.is_check_password === 0) {
                    CheckManagerAction.modal.modal('show');
                    event.preventDefault();
                }
            });
            CheckManagerAction.modal.find('#submit-manager-password').on('click', function () {
                $.post(CheckManagerAction.form.attr('action'), CheckManagerAction.form.serialize(), function (response) {
                    if (response['success']) {
                        CheckManagerAction.is_check_password = 1;
                        CheckManagerAction.modal.modal('hide');
                        CheckManagerAction.event_obj.trigger(CheckManagerAction.event);
                    } else {
                        CheckManagerAction.form.find('#check_password > .errorMessage').html('Некорректный пароль');
                    }
                });
            });
        },
        setSuccessEvent: function (initiator, event) {
            CheckManagerAction.event_obj = initiator;
            CheckManagerAction.event = event;
            return this;
        }
    };

    $(function () {
        CheckManagerAction.init();
    });
</script>
