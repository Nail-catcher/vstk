<?php

namespace App\SmsRu;

use App\SmsRu\Auth\AuthInterface;
use App\SmsRu\Client\Client;
use App\SmsRu\Client\ClientInterface;
use App\SmsRu\Entity\AbstractSms;
use App\SmsRu\Entity\Sms;
use App\SmsRu\Entity\SmsPool;
use App\SmsRu\Entity\StoplistPhone;
use App\SmsRu\Exception\Exception;
use App\SmsRu\Response\AuthCheckResponse;
use App\SmsRu\Response\MyBalanceResponse;
use App\SmsRu\Response\MyLimitResponse;
use App\SmsRu\Response\MySendersResponse;
use App\SmsRu\Response\SmsCostResponse;
use App\SmsRu\Response\SmsResponse;
use App\SmsRu\Response\SmsStatusResponse;
use App\SmsRu\Response\StoplistAddResponse;
use App\SmsRu\Response\StoplistDelResponse;
use App\SmsRu\Response\StoplistGetResponse;

class Api
{
    /**
     * @var AuthInterface
     */
    private $auth;

    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @param AuthInterface $auth
     */
    public function __construct(AuthInterface $auth)
    {
        $this->auth = $auth;
        $this->auth->setContext($this);
    }

    /**
     * @param AbstractSms $sms
     *
     * @return SmsResponse
     * @throws Exception
     */
    public function smsSend(AbstractSms $sms)
    {
        $params = [];

        if ($sms instanceof Sms) {
            $params['to'] = $sms->to;
            $params['text'] = $sms->text;
        } elseif ($sms instanceof SmsPool) {
            foreach ($sms->messages as $message) {
                $params['multi'][$message->to] = $message->text;
            }
        } else {
            throw new Exception('Only Sms or SmsPool instances');
        }

        if ($sms->from) {
            $params['from'] = $sms->from;
        }

        if ($sms->time && $sms->time < (time() + 7 * 24 * 60 * 60)) {
            $params['time'] = $sms->time;
        }

        if ($sms->translit) {
            $params['translit'] = 1;
        }

        if ($sms->test) {
            $params['test'] = 1;
        }

        if ($sms->partner_id) {
            $params['partner_id'] = $sms->partner_id;
        } elseif ($this->getAuth()->getPartnerId()) {
            $params['partner_id'] = $this->getAuth()->getPartnerId();
        }

        $response = $this->request('sms/send', $params);
        $response = explode("\n", $response);

        $smsResponse = new SmsResponse(array_shift($response));
        if ($smsResponse->code == 100) {
            foreach ($response as $id) {
                if (!preg_match('/=/', $id)) {
                    $smsResponse->ids[] = $id;
                }
//                else {
//                    $result = explode('=', $id);
//                    $response[$result[0]] = $result[1];
//                }
            }
        }

        return $smsResponse;
    }

    /**
     * @return AuthInterface
     */
    private function getAuth()
    {
        return $this->auth;
    }

    /**
     * @param string $method
     * @param array $params
     *
     * @return string
     */
    public function request($method, $params = [])
    {
        return $this->getClient()->request($method, array_merge($params, $this->getAuth()->getAuthParams()));
    }

    /**
     * @return ClientInterface
     */
    public function getClient()
    {
        if ($this->client === null) {
            $this->client = new Client();
        }

        return $this->client;
    }

    /**
     * @param ClientInterface $client
     */
    public function setClient(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $id
     *
     * @return SmsStatusResponse
     */
    public function smsStatus($id)
    {
        $response = $this->request(
            'sms/status',
            [
                'id' => $id,
            ]
        );

        $response = explode("\n", $response);

        return new SmsStatusResponse(array_shift($response));
    }

    /**
     * @param Sms $sms
     *
     * @return SmsCostResponse
     */
    public function smsCost(Sms $sms)
    {
        $params = [
            'to' => $sms->to,
            'text' => $sms->text,
        ];

        $response = $this->request('sms/cost', $params);
        $response = explode("\n", $response);

        $smsCostResponse = new SmsCostResponse(array_shift($response));
        $smsCostResponse->price = (float)$response[0];
        $smsCostResponse->length = (int)$response[1];

        return $smsCostResponse;
    }

    /**
     * @return MyBalanceResponse
     */
    public function myBalance()
    {
        $response = $this->request('my/balance');
        $response = explode("\n", $response);

        $myBalanceResponse = new MyBalanceResponse(array_shift($response));
        $myBalanceResponse->balance = (float)$response[0];

        return $myBalanceResponse;
    }

    /**
     * @return MyLimitResponse
     */
    public function myLimit()
    {
        $response = $this->request('my/limit');
        $response = explode("\n", $response);

        $myLimitResponse = new MyLimitResponse(array_shift($response));
        $myLimitResponse->limit = (int)$response[0];
        $myLimitResponse->current = (int)$response[1];

        return $myLimitResponse;
    }

    /**
     * @return MySendersResponse
     */
    public function mySenders()
    {
        $response = $this->request('my/senders');
        $response = explode("\n", $response);

        $mySendersResponse = new MySendersResponse(array_shift($response));

        foreach ($response as $phone) {
            if ($phone) {
                $mySendersResponse->phones[] = $phone;
            }
        }

        return $mySendersResponse;
    }

    /**
     * @return AuthCheckResponse
     */
    public function authCheck()
    {
        $response = $this->request('auth/check');
        $response = explode("\n", $response);

        return new AuthCheckResponse(array_shift($response));
    }

    /**
     * @param string $stoplistPhone
     * @param string $stoplistText
     *
     * @return StoplistAddResponse
     */
    public function stoplistAdd($stoplistPhone, $stoplistText)
    {
        $response = $this->request(
            'stoplist/add',
            [
                'stoplist_phone' => $stoplistPhone,
                'stoplist_text' => $stoplistText,
            ]
        );

        $response = explode("\n", $response);

        return new StoplistAddResponse(array_shift($response));
    }

    /**
     * @param string $stoplistPhone
     *
     * @return StoplistDelResponse
     */
    public function stoplistDel($stoplistPhone)
    {
        $response = $this->request(
            'stoplist/del',
            [
                'stoplist_phone' => $stoplistPhone,
            ]
        );

        $response = explode("\n", $response);

        return new StoplistDelResponse(array_shift($response));
    }

    /**
     * @return StoplistGetResponse
     */
    public function stoplistGet()
    {
        $response = $this->request('stoplist/get');
        $response = explode("\n", $response);

        $stoplistGetResponse = new StoplistGetResponse(array_shift($response));

        foreach ($response as $phone) {
            $phone = explode(';', $phone);
            $stoplistGetResponse->phones[] = new StoplistPhone($phone[0], $phone[1]);
        }

        return $stoplistGetResponse;
    }
}
