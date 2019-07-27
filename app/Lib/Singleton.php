<?php

namespace App;

trait Singleton
{

    /**
     * @var static
     */
    protected static $instance;

    /**
     * @return static
     */
    public static function i()
    {
        if (self::$instance === null) {
            self::$instance = new static();
            self::$instance->init();
        }

        return self::$instance;
    }

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    public function init()
    {
    }

}