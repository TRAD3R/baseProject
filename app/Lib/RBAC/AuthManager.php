<?php

namespace App\RBAC;

use App\Models\User;
use yii\rbac\DbManager;

/**
 * Class AuthManager
 * @package App
 */
class AuthManager extends DbManager{

    public $defaultRoles = [User::TYPE_ADMIN, User::TYPE_USER];

}