<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PortController extends Controller
{
    /**
     * 接收微信发送的消息【用户互动】
     */
    public function envet()
    {
//        $xml_string = file_get_contents('php://input');  //获取
//        $wechat_log_psth = storage_path('logs/wechat/'.date('Y-m-d').'.log');
//        file_put_contents($wechat_log_psth,"///////////开头///////////\n",FILE_APPEND);
//        file_put_contents($wechat_log_psth,$xml_string,FILE_APPEND);
//        file_put_contents($wechat_log_psth,"\n///////////结尾///////////\n\n",FILE_APPEND);
//        $xml_obj = simplexml_load_string($xml_string,'SimpleXMLElement',LIBXML_NOCDATA);
//        $xml_arr = (array)$xml_obj;
//        \Log::Info(json_encode($xml_arr,JSON_UNESCAPED_UNICODE));
        echo $_GET['echostr'];
    }
}
