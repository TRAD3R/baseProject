<?php
/**
 * @var \yii\web\View $this
 * @var string        $content
 */

use App\App;
use yii\helpers\Html;
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="icon" href="<?= App::i()->getFile()->mdUrl('/images/admin/admin-icon.png')?>">
    <?php $this->head() ?>
</head>
<body class="hold-transition skin-<?= $this->params['layout_color']?> sidebar-mini">
<?php $this->beginBody() ?>
<div class="wrapper">

    <?= $this->render('header') ?>

    <?= $this->render('left') ?>

    <?= $this->render('content', ['content' => $content]) ?>

</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
