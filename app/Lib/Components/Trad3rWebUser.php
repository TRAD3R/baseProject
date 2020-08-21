<?php

namespace App\Components;

class Trad3rWebUser extends WebUser
{

    /**
     * @param $identity
     * @param $cookieBased
     * @param $duration
     * @throws \Throwable
     */
    public function afterLogin($identity, $cookieBased, $duration)
    {
        parent::afterLogin($identity, $cookieBased, $duration);
    }
}