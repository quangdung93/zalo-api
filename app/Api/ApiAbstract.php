<?php
namespace App\Api;

use Carbon\Carbon;
use App\Models\Token;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

abstract class ApiAbstract
{
    const REFRESH_TOKEN_EXPIRES_IN = 30; // 30 days
    const URL_ACCESS_TOKEN = "https://oauth.zaloapp.com/v4/oa/access_token";

    protected function _callApi($method = "POST", $url, $data = []){
        $params['headers'] = [
            "access_token" => $this->_getAccessToken(),
            'Content-Type' => 'application/json',
        ];

        $params['json'] = $data;

        $response = (new Client)->request($method, $url, $params);

        $dataResponse = json_decode($response->getBody(), true);

        return $dataResponse;
    }

    protected function _getAccessToken(){

        if (!$this->zaloApp) {
            zalo_logging(__CLASS__.' - Zalo App not set', [], 'warning');
            return false;
        }

        if(!$this->zaloApp->access_token || $this->_hasExpired()){
            $response = $this->_callApiGetAccessToken();
    
            if(empty($response['access_token'])){
                zalo_logging('[API] Get Access Token Failed:', $response, 'error');
                return false;
            }
    
            zalo_logging('[API] Get Access Token:', $response);
    
            $this->_updateAccessToken($response);
    
            return $response['access_token'];
        }

        return $this->zaloApp->access_token;
    }

    protected function _callApiGetAccessToken(){
        //Header
        $params['headers'] = [
            "secret_key" => $this->zaloApp->app_secret,
            "Content-Type" => "application/x-www-form-urlencoded"
        ];

        //Body
        $params['form_params'] = [
            "refresh_token" => $this->zaloApp->refresh_token,
            "app_id" => $this->zaloApp->app_id,
            "grant_type" => "refresh_token"
        ];

        $resp = (new Client)->request('POST', self::URL_ACCESS_TOKEN, $params);
        $response = json_decode($resp->getBody()->getContents(), true);

        return $response;
    }

    protected function _updateAccessToken($token){
        $now = Carbon::parse(Carbon::now());

        $data = [
            'access_token' => $token['access_token'],
            'refresh_token' => $token['refresh_token'],
            'expires_in' => $now->addSeconds($token['expires_in']),
            'refresh_expires_in' => $now->addDays(self::REFRESH_TOKEN_EXPIRES_IN)
        ];

        $update = Token::where(['id' => $this->zaloApp->id])->update($data);

        $update ? zalo_logging('[Token] Update success', $data) : zalo_logging('[Token] Update failed', $data, 'warning');

        return $update;
    }

    protected function _hasExpired() {
        if($this->zaloApp->expires_in < Carbon::now()->startOfDay()) {
            return true;
        }

        return false;
    }
}
