<?php

/**
 * @var $this \yii\web\View
 * @var $content string
 */

use App\App;

?>

<header class="main-header">

    <a href="<?= \App\Helpers\Url::toRoute(['/admin'])?>" class="logo">
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
                        <?= \App\Html::a('План работ', \App\Helpers\Url::toRoute('plan/index'), ['class' => 'btn btn-info']) ?>
                    <?php endif; ?>
                </li>
                <li class="user user-menu">
                    <a href="<?= \App\Helpers\Url::toRoute(['auth/logout']) ?>">
                        <span><?= App::i()->getCurrentUser()->username; ?> <i class="fa fa-sign-out"></i></span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header>