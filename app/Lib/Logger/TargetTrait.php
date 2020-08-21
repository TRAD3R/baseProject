<?php
namespace App\Logger;

use App\App;
use Yii;
use yii\web\Request;

trait TargetTrait
{
    /**
     * Returns a string to be prefixed to the given message.
     * If [[prefix]] is configured it will return the result of the callback.
     * The default implementation will return user IP, user ID and session ID as a prefix.
     * @param array $message the message being exported.
     * The message structure follows that in [[Logger::messages]].
     * @return string the prefix string
     */
    public function getMessagePrefix($message)
    {
        if ($this->prefix !== null) {
            return call_user_func($this->prefix, $message);
        }

        if (Yii::$app === null) {
            return '';
        }

        $request = Yii::$app->getRequest();
        $ip = $request instanceof Request ? $request->getUserIP() : '-';

        try {
            $user = App::i()->getCurrentUser();
        } catch(\Exception $e) {
            $user = null;
        }

        if ($user) {
            $userID   = $user->id;
            $username = $user->username;
        } else {
            $userID   = '-';
            $username = '-';
        }

        $module = \Yii::$app->id;

        return "[$ip][$module][$username][$userID]";
    }
}