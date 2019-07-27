<?php


namespace App\Mail;

use Swift_Mime_SimpleMessage;

class SmtpTransport extends \Swift_SmtpTransport
{
    /**
     * @param Swift_Mime_SimpleMessage $message
     * @param null $failedRecipients
     * @return int
     */
    public function send(Swift_Mime_SimpleMessage $message, &$failedRecipients = null)
    {
        try{
            $sent = parent::send($message, $failedRecipients);
        }catch(\Exception $e){
            $this->restart();
            return parent::send($message, $failedRecipients);
        }

        return $sent;
    }

    public function restart()
    {
        $this->stop();
        $this->start();
    }
}