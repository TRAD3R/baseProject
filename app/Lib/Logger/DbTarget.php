<?php

namespace App\Logger;

use yii\helpers\VarDumper;
use yii\log\DbTarget as yiiDbTarget;
use yii\log\Logger;

class DbTarget extends yiiDbTarget
{
    use TargetTrait;

    public function export()
    {
        if ($this->db->getTransaction()) {
            // create new database connection, if there is an open transaction
            // to ensure insert statement is not affected by a rollback
            $this->db = clone $this->db;
        }

        $text = $prefix = '';
        $level = $category = $timestamp = null;
        foreach ($this->messages as $message) {
            list($t_text, $t_level, $t_category, $t_timestamp) = $message;
            if (is_null($level)) {
                $level = $t_level;
            }
            $t_level = Logger::getLevelName($t_level);
            if (!is_string($t_text)) {
                // exceptions may not be serializable if in the call stack somewhere is a Closure
                if ($t_text instanceof \Throwable || $text instanceof \Exception) {
                    $t_text = (string)$t_text;
                } else {
                    $t_text = VarDumper::export($t_text);
                }
            }

            $traces = [];
            if (isset($message[4])) {
                foreach ($message[4] as $trace) {
                    $traces[] = "in {$trace['file']}:{$trace['line']}";
                }
            }

            $t_prefix = $this->getMessagePrefix($message);
            $text .= date('Y-m-d H:i:s', $t_timestamp) . " {$t_prefix}[$t_level][$t_category] \n\n$t_text"
                . (empty($traces) ? '' : "\n    " . implode("\n    ", $traces) . "\n    ");
            if (empty($prefix)) {
                $prefix = $t_prefix;
            }
            if (is_null($category)) {
                $category = $t_category;
            }
            $timestamp = $t_timestamp;
        }

        $tableName = $this->db->quoteTableName($this->logTable);
        $sql       = "INSERT INTO $tableName ([[level]], [[category]], [[log_time]], [[prefix]], [[message]])
                VALUES (:level, :category, :log_time, :prefix, :message)";
        $this->db->createCommand($sql)
            ->bindValues([
            ':level'    => $level,
            ':category' => $category,
            ':log_time' => $timestamp,
            ':prefix'   => $prefix,
            ':message'  => $text,
        ])->execute();
    }
}