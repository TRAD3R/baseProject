<?php

namespace App;

class ActiveRecord extends \yii\db\ActiveRecord
{
    /**
     * @param array $columns
     * @param array $rows
     * @throws \yii\db\Exception
     */
    public static function batchInsert(array $columns, array $rows)
    {
        foreach ($rows as $i => $row) {
            if (count($row) !== count($columns)) {
                unset($rows[$i]);
            }
        }

        if (!empty($columns) && !empty($rows)) {
            App::i()->getDb()->createCommand()->batchInsert(static::tableName(), $columns, $rows)->execute();
        }
    }
}