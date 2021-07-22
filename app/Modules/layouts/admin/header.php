<?php

/**
 * @var $this \yii\web\View
 * @var $content string
 */

use App\App;
use App\Helpers\Url;
use App\Html;

?>

<header class="main-header">

    <a href="<?= Url::toRoute(['/admin'])?>" class="logo">
        <span class="logo-lg">Dashboard</span>
    </a>

    <nav class="navbar navbar-static-top">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li>
                    <?php if (App::i()->getApp()->getAuthManager()->checkAccess(App::i()->getCurrentUser()->id, 'plan/index')): ?>
                        <?= Html::a('План работ', Url::toRoute('plan/index'), ['class' => 'btn btn-info']) ?>
                    <?php endif; ?>
                </li>
                <li class="user user-menu">
                    <a href="<?= Url::toRoute(['auth/logout']) ?>">
                        <span><?= App::i()->getCurrentUser()->username; ?> <i class="fas fa-sign-out-alt"></i></span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header>