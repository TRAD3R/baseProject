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
    <link rel="icon" href="<?= App::i()->getFile()->mdUrl('/images/whocpa_admin_favicon_64.ico')?>">
    <?php $this->head() ?>
</head>
<body class="hold-transition skin-<?= $this->params['layout_color']?> sidebar-mini">
<?php $this->beginBody() ?>
<div class="wrapper">

    <?= $this->render('header') ?>

    <?= $this->render('left') ?>

    <?= $this->render('content', ['content' => $content]) ?>

</div>

<script>
    $(function () {
        NotificationQueue({url_pull_new: '<?= \App\Helpers\Url::toRoute('notification/get') ?>'});
    })
</script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
