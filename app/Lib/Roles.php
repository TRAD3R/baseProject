<?php

namespace App;

use App\Models\User;

class Roles {

	/**
	 * Константы оперделюящие к какой категории относится пользователь.
	 * Хранится в таблице {{users}} колонка role
	 */
	const ADMINISTRATOR = 1;
	const MANAGER       = 2;

	/** @var Roles */
	protected static $_instance;

	/**
	 * Приватный конструктор
	 */
	private function __construct() {

	}

	/**
	 * Приватный магический клон
	 */
	private function __clone() {

	}

	/**
	 * @return Roles
	 */
	public static function i() {
		if (static::$_instance === null) {
			self::$_instance = new static();
		}
		return self::$_instance;
	}

	/**
	 * @param User $user
	 * @return bool
	 */
	public function isAdministrator(User $user) {
		if (!$user->isAdmin()) {
			return false;
		}
		if ($user->type == User::TYPE_ADMIN) {
			return true;
		}
		return false;
	}

    /**
     * @param User $user
     *
     * @return bool
     */
    public function isManager(User $user)
    {
        if (!$user->isAdmin()) {
            return false;
        }
        if (self::isAdministrator($user)) {
            return true;
        }
        if ($user->type == User::TYPE_MANAGER) {
            return true;
        }
        return false;
    }
}