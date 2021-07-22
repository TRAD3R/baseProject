<?php
/**
 * User: vishnyakov
 * Date: 31.10.17
 * Time: 13:05
 * @var View       $this
 * @var array      $params
 * @var string     $filters_view
 * @var Pagination $pagination
 * @var array      $users
 */

use App\Helpers\Url;
use App\Html;
use yii\data\Pagination;
use yii\web\View;
use App\Models\User;

?>
<?= $this->render($filters_view, ['params' => $params]); ?>
<div class="box box-success">
    <div class="box-header with-border">
        <?= Html::pagination($this, $pagination); ?>
        <div class="pull-right">
            <a class="btn btn-primary" href="<?= Url::toRoute('user/add'); ?>" target="_blank">Добавить</a>
        </div>
    </div>
    <div class="box-body table-responsive">
        <table class="table table-stripped table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>Логин</th>
                <th>Email</th>
                <th>Статус</th>
                <th>Дата добавления</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= Html::userUrl($user['id'], '_blank', false); ?></td>
                    <td>
                        <?= Html::encode($user['username']); ?>
                    </td>
                    <td>
                        Email: <?= Html::encode($user['email']); ?>
                    </td>
                    <td><?= User::getStatus((int) $user['status']); ?></td>
                    <td>
                        <?= Html::encode($user['email']); ?>
                    </td>
                    <td>
                        <?= (new DateTime($user['date_created']))->format('d.m.Y H:i:s'); ?>
                    </td>
                    <td>
                        <div class="btn-group pull-right">
                            <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">
                                Действия
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?= Url::toRoute(['user/edit/', 'id' => $user['id']]); ?>">Изменить профиль</a></li>
                                <li><a href="<?= Url::toRoute(['user/change-password/', 'id' => $user['id']]); ?>" target="_blank">Изменить пароль</a></li>
                                <?php if ($user['type'] == User::TYPE_MANAGER): ?>
                                    <li>
                                        <a href="<?= Url::toRoute(['user/permission', 'id' => $user['id']]); ?>">Изменить права</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="box-footer">
        <?= Html::pagination($this, $pagination); ?>
    </div>
</div>

