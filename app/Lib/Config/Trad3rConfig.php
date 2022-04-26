<?php


namespace App\Config;


use App\App;
use App\Assets\AssetHelper;
use App\Assets\Packages\Trad3r\MainAsset;
use App\Helpers\TextHelper;
use App\RBAC\RbacHelper;
use Yii;

class Trad3rConfig extends Config
{
    public function getNoReplyEmail()
    {
        return App::i()->getApp()->params['emails']['noreply'];
    }

    public function getAdminBaseUrl()
    {
        return "/admin";
    }

    public function getProjectLanguage()
    {
        return App::PROJECT_LANGUAGE_EN;
    }

    public function getDefaultTimeZone()
    {
        return App::i()->getApp()->params['timezone'];
    }

    public function getCookieKey()
    {
        return App::i()->getApp()->params['cookie_key'];
    }

    public function getClientScriptConfig()
    {
        $client_script_confog = [
            // Общие скрипты для всех модулей
            AssetHelper::COMMON_PART => [
//                CommonTrad3rAssets::class
            ],
            App::CONFIG_MODULE_MAIN => [
                AssetHelper::BUNDLES => [
                    MainAsset::class
                ],
                AssetHelper::CONTROLLERS => [
                    'site' => [
                        'index' => []
                    ]
                ]
            ]
        ];

        return array_merge($client_script_confog, $this->getAdminClientScriptConfig());
    }

    public function getAdminMenuItems()
    {
        return [
            [
                'label' => 'Пользователи',
                'icon'  => 'fas fa-users',
                'url'   => '#',
                'items' => [
                    ['label' => TextHelper::upperFirstChar(Yii::t('admin', 'администраторы')), 'icon' => 'fas fa-user-shield', 'url' => ['user/administrator'],],
                    ['label' => TextHelper::upperFirstChar(Yii::t('admin', 'менеджеры')), 'icon' => 'fas fa-user-tie', 'url' => ['user/manager'],],
                ]
            ],
            [
                'label' => 'Справочники',
                'icon'  => 'fas fa-book',
                'url'   => '#',
                'items' => [
                ],
            ],
            [
                'label' => 'Настройки',
                'icon'  => 'fas fa-tools',
                'url'   => '#',
                'items' => [
                ],
            ],
        ];
    }

    public function getRbacRules()
    {
        return [
            RbacHelper::BLOCK_USER             => [
                'user/index'                     => 'Просмотр списка',
                'user/add'                       => 'Создание пользователя',
                'user/view'                      => 'Просмотр профиля',
                'user/edit'                      => 'Редактирование',
                'user/status'                    => 'Изменение статуса',
                'user/permission'                => 'Права',
            ],
        ];
    }
}