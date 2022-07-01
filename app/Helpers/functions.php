<?php 

use Illuminate\Support\Facades\Log;

if(!function_exists('zalo_logging')){
    function zalo_logging($title = 'Zalo API', $context = [], $level = 'info'){

        if(!is_array($context)){
            $context = (array)$context;
        }

        switch ($level) {
            case 'info':
                Log::info($title, $context);
                break;
            case 'warning':
                Log::warning($title, $context);
                break;
            case 'error':
                Log::error($title, $context);
                break;
            default:
                return false;
                break;
        }
    }
}