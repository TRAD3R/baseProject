<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m200821_052123_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'date_created' => $this->dateTime(),
            'date_updated' => $this->dateTime(),
            'username' => $this->string(255),
            'auth_key' => $this->string(32),
            'password_hash' => $this->string(255),
            'password_reset_token' => $this->string(255),
            'email' => $this->string(255),
            'type' => $this->tinyInteger(1),
            'status' => $this->tinyInteger(1),
        ]);

        /** Admin login: admin, password: x9ul86ucbpi2rbzj */
        $this->batchInsert('{{%user}}', ['id', 'username', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'type', 'status'], [
            [ 3, 'admin', 'orU_RzAMJgMPB1j69jhVDm52G5w5MMws',
                '$2y$13$v9xjFU7VVthNWaSPUGYhQOJq8jqUngoWWOuPdxlFPZNkIA6Ul6y1y',
                'spWb5XOMZW5nI0aGOCwT1eUwMDGjgUCD_1487250867',
                'admin@admin.admin', 1, 1
            ]
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
