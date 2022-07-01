<?php

namespace App\Http\Controllers;

use Zalo\Zalo;
use App\Models\Token;
use Illuminate\Http\Request;
use App\Services\ZaloOAService;
use Illuminate\Support\Facades\Cookie;

class ZaloController extends Controller
{   
    protected $zalo;
    const CALLBACK_URL = "https://59ad-210-245-36-141.ngrok.io/callback";

    public function __construct()
    {

        $this->zalo = new Zalo([
            'app_id' => '409339285574832352',
            'app_secret' => 'RUE6nTxRzX4E4yEKRW89',
            'callback_url' => self::CALLBACK_URL
        ]);
    }

    public function index(Request $request){
        
        // $helper = $this->zalo->getRedirectLoginHelper();

        // $linkOAGrantPermission2App = $helper->getLoginUrlByPage(self::CALLBACK_URL);
    }

    public function getUserInfo(){
        $zaloApp = Token::where('app_id', '409339285574832352')->first();
        $zaloService = new ZaloOAService($zaloApp);

        $userId = "8571189795205953325";
        $message = "Hello, Test APP";
        // $result = $zaloService->sendMessage($userId, $message);
        $result = $zaloService->getInfoOA();
        dd($result);
    }
}
