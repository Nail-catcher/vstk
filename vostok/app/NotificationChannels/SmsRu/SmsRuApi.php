<?php

namespace App\NotificationChannels\SmsRu;

use App\SmsRu\Api;
use App\SmsRu\Entity\Sms;

class SmsRuApi extends Api
{
    /**
     * @param $recipient
     * @param SmsRuMessage $message
     * @return \App\SmsRu\Response\SmsResponse
     * @throws \App\SmsRu\Exception\Exception
     */
    public function sendMessage($recipient, SmsRuMessage $message): \App\SmsRu\Response\SmsResponse
    {
        $sms = new Sms($recipient, $message->content);

        if ($message->time) {
            $sms->time = $message->time;
        }

        if ($message->test) {
            $sms->test = $message->test;
        }

        if ($message->from) {
            $sms->from = $message->from;
        }

        if ($message->translit) {
            $sms->translit = $message->translit;
        }

        if ($message->partnerId) {
            $sms->partner_id = $message->partnerId;
        }

        return $this->smsSend($sms);
    }
}
