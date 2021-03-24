<?php

namespace Admin\Controllers;


use App\App;
use App\Controller\Admin;
use App\Forms\Admin\User\AdminProfileForm;
use App\Forms\Admin\User\ChangePasswordForm;
use App\Forms\Admin\User\CreateForm;
use App\Forms\Admin\User\UserForm;
use App\Helpers\TextHelper;
use App\Helpers\Url;
use App\Html;
use App\Models\User;
use App\Params;
use App\Roles;
use App\User\SearchList\UserSearchList;
use Yii;
use yii\db\Query;

class UserController extends Admin
{
    public function beforeAction($action)
    {
        return parent::beforeAction($action);
    }

    /**
     * Список администраторов
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionAdministrator()
    {
        if (!Roles::i()->isAdministrator($this->getCurrentUser())) {
            $this->getResponse()->set403();
        }

        $params = [
            Params::USER_TYPE => User::TYPE_ADMIN,
        ];

        return $this->actionIndex($params);
    }

    /**
     * Список менеджеров
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionManager()
    {
        $params = [
            Params::USER_TYPE => User::TYPE_MANAGER,
        ];

        return $this->actionIndex($params);
    }

    /**
     * @param $params
     *
     * @return string
     */
    public function actionIndex($params = [])
    {

        if (empty($params[Params::USER_TYPE])) {
            $params[Params::USER_TYPE] = User::TYPE_MANAGER;
        }

        $titles = [
            User::TYPE_ADMIN      => Yii::t('admin', 'администраторов'),
            User::TYPE_MANAGER    => Yii::t('admin', 'менеджеров'),
        ];

        $filters_view = [
            User::TYPE_ADMIN      => 'filters/admin',
            User::TYPE_MANAGER    => 'filters/manager',
        ];

        $this->getView()->title = TextHelper::upperFirstChar(Yii::t('admin', 'список')) . ' ' . $titles[$params[Params::USER_TYPE]];

        $list = new UserSearchList($params);

        $pagination = $this->getPagination($list->getTotalCount());
        $list->setParams([
            Params::OFFSET => $pagination->getOffset(),
            Params::LIMIT  => $pagination->getLimit(),
        ], false);

        return $this->render('index', [
                'params'       => $params,
                'filters_view' => $filters_view[$params[Params::USER_TYPE]],
                'pagination'   => $pagination,
                'users'        => $list->getResults(),
            ]
        );
    }

    /**
     * Получить аяксом админа
     * @return array
     */
    public function actionGetAdmin()
    {
        return $this->getUserByType(User::TYPE_ADMIN);
    }

    /**
     * Получить аяксом админа
     * @return array
     */
    public function actionGetManager()
    {
        return $this->getUserByType(User::TYPE_MANAGER);
    }

    /**
     * @param $type
     *
     * @return array
     */
    private function getUserByType($type)
    {
        if (!$this->getRequest()->isAjax() || !$search = $this->getRequest()->getStr(Params::VALUE)) {
            return $this->getAjaxSelectResult([]);
        }

        if (is_numeric($search)) {
            $users_raw = (new Query())
                ->select(['id', 'username'])
                ->from(User::tableName())
                ->where(['id' => $search, 'type' => $type]);
        } else {
            $users_raw = (new Query())
                ->select(['id', 'username'])
                ->from(User::tableName())
                ->where(['LIKE', 'username', $search])
                ->andWhere(['type' => $type]);
        }

        $users = [];

        foreach ($users_raw->all() as $u) {
            $users[] = ['id' => $u['id'], 'text' => '[' . $u['id'] . '] ' . $u['username']];
        }

        return $this->getAjaxSelectResult($users);
    }

    /**
     * Просмотр пользователя
     * @warning - изменения профиля обслуживаются другими экшенами
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionEdit()
    {
        if (!$this->getApp()->user->can('user/view')) {
            $this->getResponse()->set403();
        }

        if (!$id = $this->getRequest()->getInt(Params::ID)) {
            $this->getResponse()->set404();
        }

        $user = User::findOne($id);

        if (!$user) {
            $this->getResponse()->set404();
        }

        $data = [
            User::TYPE_ADMIN      => [
                'view' => 'form/admin/form',
                'form' => AdminProfileForm::class,
            ],
            User::TYPE_MANAGER      => [
                'view' => 'form/admin/form',
                'form' => AdminProfileForm::class,
            ],
        ];

        /** @var UserForm $user_form */
        $user_form = new $data[$user->type]['form']($user);

        $view = $data[$user->type]['view'];

        return $this->render($view, ['user' => $user_form]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\Exception
     */
    public function actionAdd()
    {
        $this->getView()->title = 'Создание пользователя';

        $form = new CreateForm(new User());

        if ($form->load($this->getRequest()->post()) && $form->save()) {
            $this->setFlash('success', TextHelper::upperFirstChar(Yii::t('admin', 'USER_ADDED', ['user' => $form->username])));
            return $this->redirect(Url::toRoute('/admin/user'));
        }

        return $this->render('form/add', ['user' => $form]);
    }

    /**
     * Сохранение профиля менеджера
     * @throws \Exception
     */
    public function actionSaveManagerProfile()
    {
        if (!Roles::i()->isAdministrator($this->getCurrentUser())) {
            $this->getResponse()->set403();
        }

        if (!$user_id = $this->getRequest()->getInt(Params::ID)) {
            $this->getResponse()->set404();
        }

        $user = User::findOne(['id' => $user_id]);
        if (!$user) {
            $this->getResponse()->set404();
        }

        if (!$user->isEditableByUser($this->getCurrentUser())) {
            $this->getResponse()->set403();
        }

        $profile_form = new AdminProfileForm(User::findOne(['id' => $user_id]));

        if ($profile_form->load($this->getRequest()->post()) && $profile_form->validate()) {
            if ($profile_form->save()) {
                $this->setFlash('success', 'Настройки успешно сохранены');
                return ['success' => 1];
            }
        }

        return ['success' => 0];
    }

    /**
     * @return string
     * @throws \Exception
     * @throws \yii\web\HttpException
     */
    public function actionPermission()
    {
        $manager_id = $this->getRequest()->getInt('id');
        $manager    = User::findOne(['id' => $manager_id, 'type' => User::TYPE_MANAGER]);
        if (!$manager) {
            $this->getResponse()->set404();
        }

        $auth_manager        = $this->getApp()->getAuthManager();
        $manager_permissions = $auth_manager->getPermissionsByUser($manager_id);

        if ($this->getRequest()->isPost()) {
            $auth_manager->revokeAll($manager->id);
            $permissions = $this->getRequest()->postArray('permissions', []);

            foreach ($permissions as $permission => $check) {
                if (!$permission) {
                    continue;
                }
                if ($permission = $auth_manager->getPermission($permission)) {
                    $auth_manager->assign($permission, $manager_id);
                }
                $manager_permissions = $auth_manager->getPermissionsByUser($manager_id);
            }
        }

        $this->view->title = 'Редактирование прав менеджера [' . $manager->id . '] ' . $manager->username;

        return $this->render('permission', ['manager_permissions' => $manager_permissions]);
    }


    /**
     * @throws \Exception
     */
    public function actionChangePassword()
    {
        if (!$this->getApp()->user->can('user/edit')) {
            $this->getResponse()->set403();
        }

        if (!$id = $this->getRequest()->getInt(Params::ID)) {
            $this->getResponse()->set404();
        }

        $user = User::findOne($id);

        if (!$user || !$user->isEditableByUser($this->getCurrentUser())) {
            $this->getResponse()->set403();
        }

        // Менеджеры не могут редактировать профиль другого менеджера, если тот старше него.
        if (App::i()->getCurrentUser()->type == User::TYPE_ADMIN && $user->type == User::TYPE_ADMIN && App::i()->getCurrentUser()->role > $user->role) {
            $this->getResponse()->set403();
        }

        $model = new ChangePasswordForm($user);

        if ($this->getRequest()->isPost() && $model->load($this->getRequest()->post())) {
            if ($model->save()) {
                $this->setFlash('success', TextHelper::upperFirstChar(Yii::t('admin', 'Пароль успешно изменен')));
                return $this->redirect(Url::toRoute('/admin/user'));
            }
        }

        $this->getView()->title = TextHelper::upperFirstChar(Yii::t('admin', 'CHANGE_USER_PASSWORD_TITLE', ['user' => Html::encode($user->username), 'id' => $user->id]));

        return $this->render('change-password', ['model' => $model]);
    }
}