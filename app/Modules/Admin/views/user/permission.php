<?php
/**
 * @var Permission[] $manager_permissions
 */

use App\Html;
use App\RBAC\RbacHelper;
use yii\rbac\Permission;

?>
<?= Html::beginForm() ?>

<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <?php foreach (RbacHelper::getRules() as $block_name => $rules): ?>
                <div class="col-md-2">
                    <div class="box box-success collapsed-box">
                        <div class="box-header with-border">
                            <?= RbacHelper::getRuleBlockName($block_name) ;?>
                            <div class="pull-right">
                                <?= Html::button('<i class="fa fa-check"></i>', ['class' => 'btn btn-success btn-xs select-all']) ?>
                                <?= Html::button('<i class="fa fa-times"></i>', ['class' => 'btn btn-default btn-xs unselect-all']) ?>
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                            <?php foreach($rules as $rule => $message) : ?>
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <?= Html::checkBox('permissions[' . $rule . ']', $manager_permissions[$rule] ? true : null) ?>
                                            <?= $message ?>
                                        </label>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
        <?php endforeach;?>
        </div>
    </div>
    <div class="col-xs-12">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
</div>

<?= Html::endForm() ?>

<script>
    $('.select-all').click(function(){
        var block = $(this).closest('.box');
        var inputs = block.find('input:checkbox');
        inputs.each(function(){
            $(this).prop('checked', true);
        });
    });

    $('.unselect-all').click(function(){
        var block = $(this).closest('.box');
        var inputs = block.find('input:checkbox');
        inputs.each(function(){
            $(this).prop('checked', false);
        });
    });
</script>
