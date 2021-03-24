<?php

namespace App\Forms\Admin\User;

use App\Forms\Main\User\LoginForm;
use App\Helpers\PasswordHelper;
use App\Models\User;

class ChangePasswordForm extends LoginForm
{

    public $password;
    public $password_repeat;
    public $id;

    public function __construct(User $entity = null)
    {
        parent::__construct($entity);
        $this->setAttributes($entity->getAttributes(), false);
    }

    public function rules()
    {
        return [
            ['password', 'compare', 'compareAttribute' => 'username', 'operator' => '!=', 'message' => 'Пароль совпадает с именем пользователя, его будет очень легко подобрать :('],
            ['password', 'isPasswordWeak', 'params' => ['message' => 'Этот пароль входит в ТОП 1000 самых слабых, его будет очень легко подобрать :(']],
            ['password', 'required', 'message' => 'Введите новый пароль'],
            ['password_repeat', 'required', 'message' => 'Повторите пароль'],
            ['password', 'string', 'min' => 6, 'tooShort' => 'Пароль должен состоят из минимум 6 символов'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'skipOnEmpty' => false, 'message' => 'Пароли не сопадают.'],
        ];
    }

    public function isPasswordWeak($attribute, $params)
    {
        if (PasswordHelper::isWeak($this->$attribute)) {
            $this->addError($attribute, $params['message']);
        }
    }

    /**
     * @return bool
     * @throws \yii\base\Exception
     */
    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        /** @var User $user */
        $user = $this->_entity;
        $user->setPassword($this->password);
        $user->generatePasswordResetToken();
        $user->save();

        return true;
    }
}
