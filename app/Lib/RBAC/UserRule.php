<?php

namespace App\RBAC;

use App\App;
use App\Models\User;
use Yii;
use yii\rbac\Item;
use yii\rbac\Rule;

class UserRule extends Rule {

    public $name = 'userRole';

    /**
     * @param int|string $user
     * @param Item       $item
     * @param array      $params
     * @return bool
     */
    public function execute($user, $item, $params)
    {
        if (!Yii::$app->user->isGuest) {
            $user = App::i()->getCurrentUser();
            $type = $user->type;

            if ($item->name == User::TYPE_MANAGER) {
                return $type == User::TYPE_MANAGER;
            } elseif ($item->name == User::TYPE_ADMIN) {
                return $type == User::TYPE_ADMIN;
            }
        }
        return false;
    }
}