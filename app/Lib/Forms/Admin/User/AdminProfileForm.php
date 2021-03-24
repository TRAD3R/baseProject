<?php

namespace App\Forms\Admin\User;


use App\Models\User;

class AdminProfileForm extends UserForm
{
    public $id;
    public $username;
    public $email;
    public $type;
    public $status;

    /**
     * ManagerProfileForm constructor.
     * @param User|null $user
     */
    public function __construct(User $user = null)
    {
        parent::__construct($user);

        $this->setAttributes($this->_entity->getAttributes(), false);
    }


    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['email', 'type', 'status'], 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
        ];
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
        $user              = $this->_entity;
        $user->email       = $this->email;
        $user->type        = $this->type;
        $user->status      = $this->status;

        return $user->save();
    }
}