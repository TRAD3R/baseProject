<?php
namespace App\Forms\Admin\User;

use App\App;
use App\Forms\Main\User\LoginForm;
use App\Models\User;

class LoginAdminForm extends LoginForm
{

    public $remember_me = true;

    public function rules()
    {
        return [
            ['username', 'required', 'message' => 'Введите логин'],
            ['password', 'required', 'message' => 'Введите пароль'],
            ['remember_me', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * @return bool|User
     */
    public function getUser()
    {
        if ($this->_entity === false) {
            $this->_entity = User::findOne([
                'username' => $this->username,
            ]);

        }

        return $this->_entity;
    }

    public function login()
    {
        if ($this->validate()) {
            if ($this->getUser()->status != User::STATUS_ACTIVE) {
                $this->addError('error', 'Ваш аккаунт заблокирован!');
                return false;
            }

            return App::i()->getApp()->user->login($this->getUser(), $this->remember_me ? 3600 * 24 * 30 : 0);
        }
        return false;
    }
}
