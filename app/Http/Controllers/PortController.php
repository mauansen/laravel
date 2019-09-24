<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class PortController extends Controller
{
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
        $user_openid = $xml_arr['FromUserName']; //粉丝openid
        if($xml_arr['MsgType'] == 'event'){
            if($xml_arr['Event'] == 'subscribe'){
                $share_code = explode('_',$xml_arr['EventKey'])[1];
                //判断openid是否已经在日志表
                $wechat_openid = DB::table('wechat_openid')->where(['openid'=>$user_openid])->first();
                if(empty($wechat_openid)){
                    DB::table('wechat_user')->where(['id'=>$share_code])->increment('sum',1);
                    DB::table('wechat_openid')->insert([
                        'openid'=>$user_openid,
                        'add_time'=>time()
                    ]);
                }
            }
        }
        $point=DB::table('wechat_user')->where(['open_id'=>$user_openid])->first();
        if($xml_arr['EventKey'] == 'qiandao'){
            if($point->or_sign == 1){
                $a='已签到';
            }else if($point->or_sign == 2){
                if($point->sign==1){
                    $points=$point->points+5;
                    $sign=$point->sign+1;
                }
                if($point->sign==2){
                    $points=$point->points+10;
                    $sign=$point->sign+1;
                }
                if($point->sign==3){
                    $points=$point->points+15;
                    $sign=$point->sign+1;
                }
                if($point->sign==4){
                    $points=$point->points+20;
                    $sign=$point->sign+1;
                }
                if($point->sign==5){
                    $points=$point->points+25;
                    $sign=$point->sign+1;
                }
                if($point->sign==6){
                    $points=$point->points+5;
                    $sign=1;
                }
                DB::table('wechat_user')->where(['open_id'=>$user_openid])->update([
                    'points'=>$points,
                    'or_sign'=>1,
                    'sign'=>$sign,
                    'sign_time'=>time()
                ]);
                $a='签到成功';
            }
        }else if($xml_arr['EventKey'] == 'chaxun'){
            $a='您的积分为:'.$point->points;
        }
        $message = empty($a)?'欢迎关注！': $a;
        $xml_str = '<xml><ToUserName><![CDATA['.$xml_arr['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml_arr['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
        echo $xml_str;
    }

}
