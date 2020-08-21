<?php

namespace App\Components;

use App\App;
use App\Models\User;
use yii\web\IdentityInterface;
use yii\web\User as Base;

class WebUser extends Base
{
    public function setIdentity($identity)
    {
        /** @var User $identity */
        if ($this->getIsGuest() && $identity) {
            /** todo запрос идет два раза за приложение! нужно исправить на один запрос */

        }

        parent::setIdentity($identity);
    }
}