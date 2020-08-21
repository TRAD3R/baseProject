<?php

namespace App\Models;

use App\App;
use App\Behaviors\Timestamp;
use App\ActiveRecord;
use Yii;
use yii\web\IdentityInterface;

/**
 * Class User
 *
 * @property int                   $id                                  ID
 * @property string                $username                            [varchar(255)]
 * @property string                $auth_key                            [varchar(32)]
 * @property string                $password_hash                       [varchar(255)]
 * @property string                $password_reset_token                [varchar(255)]
 * @property string                $email                               [varchar(255)]
 * @property int                   $type                                [smallint(6)]
 * @property int                   $status                              [smallint(6)]
 */
class User extends ActiveRecord implements IdentityInterface
{
    const TYPE_ADMIN = 1;
    const TYPE_USER  = 2;

    const STATUS_NOT_ACTIVE     = 0;
    const STATUS_ACTIVE         = 1;

    const PASSWORD_RESET_TOKEN_TTL = 3600;

    const DEFAULT_ADMIN_ID = 3;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * Поведения для дат
     * @return array
     */
    public function behaviors()
    {
        return [
            Timestamp::class,
        ];
    }



    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * @param mixed $token
     * @param null  $type
     * @return self
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
//        return self::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * Метод для
     * @return string
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Валидация по кукам
     * @param string $authKey
     * @return bool
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Генерируем и установаливаем хеш пароля
     * @param string $password
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Генерируем и устанавдиваем auth_key
     * @throws \yii\base\Exception
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Валидация пароля через заебизь
     * @param $password
     * @return bool
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Проверяем действует ли токен сброса пароля
     * @param string $token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);

        return $timestamp + self::PASSWORD_RESET_TOKEN_TTL >= time();
    }

    /**
     * Генерируем и устанавливаем токен для сброса пароля
     * @throws \yii\base\Exception
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Ищем по токену сброса пароля
     * @param $token
     * @return null|self()
     */
    public static function findByResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return self::findOne([
            'password_reset_token' => $token,
            'status'               => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * @param null $type
     * @return array|mixed
     */
    public static function getUserType($type = null)
    {
        $types = [
            self::TYPE_ADMIN => 'Админстратор',
            self::TYPE_USER  => 'Пользователь',
        ];

        return isset($types[$type]) ? $types[$type] : $types;
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->type == self::TYPE_ADMIN;
    }

    /**
     * @return bool
     */
    public function isUser()
    {
        return $this->type == self::TYPE_USER;
    }

    /**
     * Возвращает ссылку на главное приложение
     * @return string
     */
    public function getUserBaseUrl()
    {
        $urls = [
            self::TYPE_ADMIN      => App::i()->getConfig()->getAdminBaseUrl(),
        ];

        return isset($urls[$this->type]) ? $urls[$this->type] : '/';
    }

    /**
     * @param null $status
     * @return array|mixed
     */
    public static function getStatus($status = null)
    {
        $arr = [
            self::STATUS_NOT_ACTIVE     => 'Неактивен',
            self::STATUS_ACTIVE         => 'Активен',
        ];

        return isset($arr[$status]) ? $arr[$status] : $arr;
    }

    public static function getActiveStatuses()
    {
        return [self::STATUS_ACTIVE];
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return in_array($this->status, self::getActiveStatuses());
    }
}