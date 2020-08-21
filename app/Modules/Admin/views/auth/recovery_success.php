<?php
/**
 * @var \yii\web\View       $this
 * @var string              $email
 */
use App\Html;

?>

<div class="login-box">
    <div class="login-box-body">
        <div class="box-title text-center">
            <h3>Done!</h3>
        </div>
        <p>
            We will send an email to <strong><?= Html::encode($email) ?></strong> explaining how to reset your password.
        </p>
    </div>
</div>
