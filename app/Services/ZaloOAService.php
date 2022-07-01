<?php

namespace App\Services;

use Zalo\ZaloEndpoint;
use App\Api\ApiAbstract;

class ZaloOAService extends ApiAbstract
{
    public $zaloApp = null;

    const URL_SEND_MESSAGE = "https://openapi.zalo.me/v2.0/oa/message";
    const URL_QUOTE_MESSAGE = "https://openapi.zalo.me/v2.0/oa/quota/message";
    const URL_INFO_OA = "https://openapi.zalo.me/v2.0/oa/getoa";

    public function __construct($zaloApp = null){
        if($zaloApp){
            $this->zaloApp = $zaloApp;
        }
    }

    public function sendMessage($userId, $message){
        $params = [
            'recipient' => ['user_id' => $userId],
            'message' => ['text' => $message]
        ];

        return $this->_callApi('POST', self::URL_SEND_MESSAGE, $params);
    }

    public function getQuoteMessage(){
        return $this->_callApi('POST', self::URL_QUOTE_MESSAGE);
    }

    public function getInfoOA(){
        return $this->_callApi('GET', self::URL_INFO_OA);
    }

}
