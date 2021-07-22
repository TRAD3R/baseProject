<?php
/**
 * User: vishnyakov
 * Date: 17.11.17
 * Time: 11:25
 */

namespace App\Forms\Admin\User;

use App\Helpers\TextHelper;
use App\Model;
use Yii;

/**
 * Базовая форма для профилей менеджеров
 * Class UserForm
 * @package App\Forms\Admin\User
 */
class UserForm extends Model
{
    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'username'          => TextHelper::upperFirstChar(Yii::t('admin', 'логин')),
            'type'              => TextHelper::upperFirstChar(Yii::t('admin', 'тип')),
            'status'              => TextHelper::upperFirstChar(Yii::t('admin', 'статус')),
        ];
    }

}