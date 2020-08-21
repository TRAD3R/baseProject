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
    <html>
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="icon" type="image/png" href="<?= App::i()->getFile()->mdUrl('/images/icons/whocpa_favicon_color_16.png?up=1'); ?>">
        <link rel="shortcut icon" href="<?= App::i()->getFile()->mdUrl('/images/icons/whocpa_favicon_color_16.png?up=1'); ?>" type="image/x-icon">
        <?php $this->head() ?>
    </head>
    <body class="layout-top-nav">
    <?php $this->beginBody() ?>
    <div class="wrapper">
        <div class="content-wrapper">
            <section class="content">
                <div class="error-page">
                    <?= $content ?>
                </div>
            </section>
        </div>
    </div>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>