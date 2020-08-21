<?php
/**
 * @var \yii\web\View       $this
 * @var \App\Models\CpaUser $user
 */
use App\Html;

?>

<div class="login-box">
    <div class="login-box-body">
        <div class="box-title text-center">
            <h2>Thanks for signing up!</h2>
        </div>
        <p>
            We will send an email to <a href="javascript:void(0);"><?= Html::encode($user->email) ?></a> with a link to activate your account.
            If you don't receive it, please check your spam folder.
        </p>
        <p>
            If you didn't get it we could <a href="javascript:void(0);" id="repeat">resend it</a>.
        </p>
        <div class="text-center text-success" id="success-resend" style="display: none">
            Email was successfully sent
        </div>
    </div>
</div>

<script>
    $(function () {
        $('#repeat').on('click', function () {
            $.post('<?= \App\Helpers\Url::toRoute(['resend']) ?>', {i: '<?= $user->email ?>', _csrf: '<?= Yii::$app->getRequest()->csrfToken ?>'}, function (response) {
                if (response.success) {
                    $('#success-resend').slideDown();
                    setTimeout(function () {
                        $('#success-resend').slideUp();
                    }, 2500);
                    return false;
                }
            }, 'json')
        })
    })
</script>