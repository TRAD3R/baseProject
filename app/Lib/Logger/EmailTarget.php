<?php

namespace App\Logger;

use App\App;
use App\Cache\Redis;
use yii\helpers\VarDumper;
use yii\log\EmailTarget as yiiEmailTarget;
use yii\log\Logger;

class EmailTarget extends yiiEmailTarget
{
    use TargetTrait;

    const CATEGORY_COMMON = 'common';

    public $message_hash = '';

    public function export()
    {
        $module = \Yii::$app->id;
        if (empty($this->message['subject'])) {
            $this->message['subject'] = App::i()->getProjectName(App::i()->getProjectId()) . ' - ' . $module;
        }

        $messages = array_map([$this, 'formatMessage'], $this->messages);

        $hash = md5($this->message_hash);
        if (!App::i()->getCache()->get(Redis::ERROR_EMAIL_HASH . ':' . $hash)) {
            App::i()->getCache()->set(Redis::ERROR_EMAIL_HASH . ':' . $hash, 1, 60);
            $body = implode("\n\n", $messages);
            $this->composeMessage($body)->send($this->mailer);
        }
    }

    /**
     * Formats a log message for display as a string.
     * @param array $message the log message to be formatted.
     * The message structure follows that in [[Logger::messages]].
     * @return string the formatted message
     */
    public function formatMessage($message)
    {
        list($text, $level, $category, $timestamp) = $message;

        if ($category === self::CATEGORY_COMMON) {
            $this->message['subject'] = App::i()->getProjectName(App::i()->getProjectId()) . ' - common';
        }
        $level_text = Logger::getLevelName($level);
        if (!is_string($text)) {
            // exceptions may not be serializable if in the call stack somewhere is a Closure
            if ($text instanceof \Throwable || $text instanceof \Exception) {
                $text = (string) $text;
            } else {
                $text = VarDumper::export($text);
            }
        }
        $traces = [];
        if (isset($message[4])) {
            foreach ($message[4] as $trace) {
                $traces[] = "in {$trace['file']}:{$trace['line']}";
            }
        }

        $prefix = $this->getMessagePrefix($message);

        if ($level != Logger::LEVEL_INFO) {
            $this->message_hash .= $text . $prefix;
        }
        return date('Y-m-d H:i:s', $timestamp) . " {$prefix}[$level_text][$category] \n\n$text"
            . (empty($traces) ? '' : "\n    " . implode("\n    ", $traces) . "\n    ");
    }
}