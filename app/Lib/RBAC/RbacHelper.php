<?php

namespace App\RBAC;

use App\App;

class RbacHelper
{
    const BLOCK_USER             = 1;

    public static function getRuleBlockName($block)
    {
        $block_names = [
                self::BLOCK_USER             => 'Пользователи',
        ];

        return isset($block_names[$block]) ? $block_names[$block] : $block_names;
    }

    public static function getRules()
    {
        return App::i()->getConfig()->getRbacRules();
    }
}