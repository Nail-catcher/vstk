<?php

namespace App\SmsRu\Client;

interface ClientInterface
{

    /**
     * @param string $method
     * @param array $params
     *
     * @return string
     */
    public function request($method, $params = []);
}
