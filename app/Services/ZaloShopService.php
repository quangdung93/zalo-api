<?php

namespace App\Services;

use App\Api\ApiAbstract;

class ZaloShopService extends ApiAbstract
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

}
