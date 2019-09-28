<?php

namespace App\Http\Controllers;

use App\Tools\Tools;
use Illuminate\Http\Request;
use DB;
class PortController extends Controller
{
    public $tools;
    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }
    /**
     * 接收微信发送的消息【用户互动】
     */
    public function envet()
    {
        $xml_string = file_get_contents('php://input');  //获取
        $wechat_log_psth = storage_path('logs/wechat/'.date('Y-m-d').'.log');
        file_put_contents($wechat_log_psth,"///////////开头///////////\n",FILE_APPEND);
        file_put_contents($wechat_log_psth,$xml_string,FILE_APPEND);
        file_put_contents($wechat_log_psth,"\n///////////结尾///////////\n\n",FILE_APPEND);
        $xml_obj = simplexml_load_string($xml_string,'SimpleXMLElement',LIBXML_NOCDATA);
        $xml_arr = (array)$xml_obj;
        \Log::Info(json_encode($xml_arr,JSON_UNESCAPED_UNICODE));
        if($xml_arr['Event'] == 'subscribe' && $xml_arr['MsgType'] == 'event') {
            $point=DB::table('wechat_user')->where(['open_id'=>$xml_arr['FromUserName']])->first();
            $data=file_get_contents('https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->tools->get_wechat_access_token().'&openid='.$xml_arr['FromUserName'].'&lang=zh_CN');
            $data=json_decode($data,1);
            if(empty($point)){
                DB::table('wechat_user')->insert([
                    'open_id'=>$xml_arr['FromUserName'],
                    'nickname'=>$data['nickname'],
                    'add_time'=>time(),
                    'sex'=>$data['sex']
                ]);
                $message='您好'.$data['nickname'].'当前时间为'.date('Y-m-d H:i:s',time());
                $xml_str = '<xml><ToUserName><![CDATA['.$xml_arr['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml_arr['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
                $wechat_log_psth = storage_path('logs/wechat/'.date('Y-m-d').'.log');
                file_put_contents($wechat_log_psth,"///////////开头///////////\n",FILE_APPEND);
                file_put_contents($wechat_log_psth,$xml_str,FILE_APPEND);
                file_put_contents($wechat_log_psth,"\n///////////结尾///////////\n\n",FILE_APPEND);
                echo $xml_str;
            }else{
                $message='欢迎回来'.$data['nickname'].'当前时间为'.date('Y-m-d H:i:s',time());
                $xml_str = '<xml><ToUserName><![CDATA['.$xml_arr['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml_arr['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
                $wechat_log_psth = storage_path('logs/wechat/'.date('Y-m-d').'.log');
                file_put_contents($wechat_log_psth,"///////////开头///////////\n",FILE_APPEND);
                file_put_contents($wechat_log_psth,$xml_str,FILE_APPEND);
                file_put_contents($wechat_log_psth,"\n///////////结尾///////////\n\n",FILE_APPEND);
                echo $xml_str;
            }
        }
////        签到
//        if($xml_arr['EventKey'] == 'qiandao'){
//            if($point->or_sign == 1){
//                $message='已签到';
//                $xml_str = '<xml><ToUserName><![CDATA['.$xml_arr['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml_arr['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
//                echo $xml_str;
//            }else if($point->or_sign == 2){
//                if($point->sign==1||$point->sign=='0'){
//                    $points=$point->points+5;
//                    $sign=$point->sign+1;
//                }
//                if($point->sign==2){
//                    $points=$point->points+10;
//                    $sign=$point->sign+1;
//                }
//                if($point->sign==3){
//                    $points=$point->points+15;
//                    $sign=$point->sign+1;
//                }
//                if($point->sign==4){
//                    $points=$point->points+20;
//                    $sign=$point->sign+1;
//                }
//                if($point->sign==5){
//                    $points=$point->points+25;
//                    $sign=$point->sign+1;
//                }
//                if($point->sign==6){
//                    $points=$point->points+5;
//                    $sign=1;
//                }
//                DB::table('wechat_user')->where(['open_id'=>$xml_arr['FromUserName']])->update([
//                    'points'=>$points,
//                    'or_sign'=>1,
//                    'sign'=>$sign,
//                    'sign_time'=>time()
//                ]);
//                $message='签到成功';
//                $xml_str = '<xml><ToUserName><![CDATA['.$xml_arr['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml_arr['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
//                echo $xml_str;
//            }
//        }else if($xml_arr['EventKey'] == 'chaxun'){
//            $message='您的积分为:'.$point->points.'分';
//            $xml_str = '<xml><ToUserName><![CDATA['.$xml_arr['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml_arr['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
//            echo $xml_str;
//        }

    }

}
