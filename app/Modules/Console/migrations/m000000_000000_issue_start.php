<?php

use yii\db\Migration;
use yii\base\InvalidConfigException;
use yii\rbac\DbManager;

class m000000_000000_issue_start extends Migration
{
    public function safeUp()
    {
        /** Admin login: admin, password: x9ul86ucbpi2rbzj */
        $this->execute(file_get_contents(__DIR__ . '/dump.sql'));

    }

    public function safeDown()
    {

        $this->dropTable('{{%user}}');

        /** @var DbManager $authManager */
        $authManager = $this->getAuthManager();

        $this->dropTable($authManager->assignmentTable);
        $this->dropTable($authManager->itemChildTable);
        $this->dropTable($authManager->itemTable);
        $this->dropTable($authManager->ruleTable);
    }

    /**
     * @return \yii\rbac\ManagerInterface
     * @throws InvalidConfigException
     */
    protected function getAuthManager()
    {
        $authManager = Yii::$app->getAuthManager();
        if (!$authManager instanceof DbManager) {
            throw new InvalidConfigException('You should configure "authManager" component to use database before executing this migration.');
        }
        return $authManager;
    }
}
