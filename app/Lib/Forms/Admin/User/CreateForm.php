<?php
/**
 * User: vishnyakov
 * Date: 28.11.17
 */

namespace App\Forms\Admin\User;

use App\App;
use App\Helpers\TextHelper;
use App\Model;
use App\Models\User;
use Yii;

class CreateForm extends Model
{

    public $username;
    public $password;
    public $password_repeat;
    public $email;
    public $type;
    public $status;

    /**
     * CreateForm constructor.
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
    public function attributeLabels()
    {
        return [
            'username'          => TextHelper::upperFirstChar(Yii::t('admin', 'логин')),
            'password'          => TextHelper::upperFirstChar(Yii::t('admin', 'пароль')),
            'password_repeat'   => TextHelper::upperFirstChar(Yii::t('admin', 'повторите пароль')),
            'type'              => TextHelper::upperFirstChar(Yii::t('admin', 'тип')),
            'status'            => TextHelper::upperFirstChar(Yii::t('admin', 'статус')),
        ];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['username', 'password', 'password_repeat', 'email', 'type', 'status'], 'required'],
            ['username', 'validateUnique'],
            ['email', 'validateUnique'],
            ['username', 'string', 'min' => 4, 'max' => 255],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['password', 'string', 'min' => 6],
            [
                'password_repeat',
                'compare',
                'compareAttribute' => 'password',
                'skipOnEmpty'      => false,
                'message'          => Yii::t('exception', 'PASSWORDS_NOT_SAME'),
            ],
        ];
    }

    /**
     * @param $attribute
     */
    public function validateUnique($attribute)
    {
        if (User::findOne([$attribute => $this->$attribute])) {
            $this->addError($attribute, Yii::t('exception', 'DUBLICATE_USER_ATTRIBUTE', ['attribute' => $attribute]));
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
        $user           = $this->_entity;
        $user->username = $this->username;
        $user->email    = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generatePasswordResetToken();
        $user->type        = $this->type;
        $user->status      = $this->status;

        if ($user->save()) {
            $auth_manager        = App::i()->getApp()->getAuthManager();
            $permissions = $auth_manager->getPermissions();

            foreach ($permissions as $permission) {
                if($user->type == User::TYPE_MANAGER) {
                    if (!in_array($permission->name, ['site/index'])) {
                        continue;
                    }
                }
                $auth_manager->assign($permission, $user->id);
            }

            return true;
        }

        return false;
    }
}