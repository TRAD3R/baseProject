<?php
/**
 * @var \yii\web\View $this
 */

use App\Helpers\Url;
use App\Html;
use App\Params;
use App\Widgets\Menu;

?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- search form -->
        <?= Html::beginForm(Url::toRoute('search/search'), 'post', ['class' => 'sidebar-form']) ?>
            <div class="input-group">
                <input type="text" name="<?= Params::SEARCH ?>" class="form-control" placeholder="Search..."/>
                <span class="input-group-btn">
                <button type="submit" id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
        <?= Html::endForm() ?>
        <!-- /.search form -->
        <?= Menu::widget($this->params['module_menu']) ?>

    </section>

</aside>
