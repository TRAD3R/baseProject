<?php
namespace Console\Trad3r\Controllers;

use Yii;
use yii\console\Controller;
use App\Models\User;

class RbacStartController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // добавляем роль "user"
        $user = $auth->createRole(User::TYPE_ADMIN);
        $auth->add($user);

        // добавляем роль "admin"
        $admin = $auth->createRole(User::TYPE_USER);
        $auth->add($admin);
        $auth->addChild($admin, $user);
    }

}