<?php

namespace App\Forms\Main\User;

use App\Models\User;
use App\Model;
use Yii;

/**
 * Class LoginForm
 * @property User $_entity
 * @package App\Forms\Main\User
 */
class LoginForm extends Model
{
    const BAD_USERNAME_ATTEMPTS = 3;

    const BAD_FINGERPRINT_ATTEMPTS = 5;

    public $username;
    public $password;
    public $remember_me;

    public $error;

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['remember_me', 'boolean'],
            ['password', 'checkAttempts'],
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username'   => _('Username'),
            'password'   => _('Password'),
            'remember_me' => _('Remember me')
        ];
    }

    public function validatePassword()
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError('username', '');
                $this->addError('password', _('Incorrect username or password') . '!');
            }
        }
    }

    public function login()
    {
        if ($this->validate()) {
            if (!$this->getUser()->isActive()) {
                $this->addError('username', '');
                $this->addError('password', _('Your account has been blocked.') . '!');
                return false;
            }
            return Yii::$app->user->login($this->getUser(), $this->remember_me ? 3600 * 24 * 30 : 0);
        }

        return false;
    }

    /**
     * @return bool|User
     */
    public function getUser()
    {
        if ($this->_entity === false) {
            $this->_entity = User::find()
                ->where([
                    'OR',
                    ['username' => $this->username],
                    ['email' => $this->username],
                ])
                ->andWhere(['IN', 'type', [User::TYPE_MANAGER]])
                ->one();
        }

        return $this->_entity;
    }
}
