<?php

namespace App\Http\Controllers\admin;
use App\Tools\Tools;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class AdminController extends Controller
{
    public $tools;
    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }
//    后台登陆
    public function login()
    {
        return view('nine.login');
    }
//    登陆执行
    public function login_int()
    {
        $data=request()->except('_token');
        $res=DB::table('nine')->where(['name'=>$data['name']])->first();
        if($res){
            if($data['pwd']==$res->pwd){
                return redirect('nine/index');

            }else{
               return redirect('nine/login');

            }
        }else{
            return redirect('nine/login');
        }
    }
//    绑定账号
    public function accout()
    {
        $req = request()->all();
        if(empty($req)){
            $result = file_get_contents('https://api.weixin.qq.com/sns/oauth2/access_token?appid='.env('WECHAT_APPID').'&secret='.env('SECRET').'&code='.$req['code'].'&grant_type=authorization_code');
            $re = json_decode($result,1);
            $user_info = file_get_contents('https://api.weixin.qq.com/sns/userinfo?access_token='.$re['access_token'].'&openid='.$re['openid'].'&lang=zh_CN');
            $wechat_user_info = json_decode($user_info,1);
            dd($wechat_user_info);
        }else{
            $redirect_uri =  env('APP_URL').'nine/accout';
            $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.env('WECHAT_APPID').'&redirect_uri='.urlencode($redirect_uri).'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
            header('Location:'.$url);
        }


        return view('nine.accout');
    }
    public function wechat_login()
    {

        //echo $url;die();
    }
    public function code(Request $request)
    {
        $req = $request->all();
        $result = file_get_contents('https://api.weixin.qq.com/sns/oauth2/access_token?appid='.env('WECHAT_APPID').'&secret='.env('SECRET').'&code='.$req['code'].'&grant_type=authorization_code');
        $re = json_decode($result,1);
        $user_info = file_get_contents('https://api.weixin.qq.com/sns/userinfo?access_token='.$re['access_token'].'&openid='.$re['openid'].'&lang=zh_CN');
        $wechat_user_info = json_decode($user_info,1);
//        dd($wechat_user_info);
        $open_id=DB::table('wechat')->where(['open_id'=>$wechat_user_info['openid']])->first();
        if(!empty($open_id)){
//            存在
            request()->session()->put('tel',$wechat_user_info);
//            return 'ok'
            return redirect('/');

        }else{
//            不存在
            DB::beginTransaction();
            $l_id=DB::table('login')->insertGetId([
                'tel'=>$wechat_user_info['nickname'],
                'pwd'=>'',
                'time'=>time(),
            ]);
            DB::table('wechat')->insert([
                'l_id'=>$l_id,
                'open_id'=>$wechat_user_info['openid'],
            ]);
//            return 123456789;
            request()->session()->put('tel',$wechat_user_info);
            return redirect('/');

        }
    }
//    public function accout_do()
//    {
//        $data=request()->except('_token');
//        $res=DB::table('nine')->where(['name'=>$data['name']])->first();
//        if($res){
//            if($data['pwd']==$res->pwd){
//
////                DB::table('nine')->where('id','=',$res->id)->update([
////                    'openid'=>
////                ]);
//
//            }else{
//
//
//            }
//        }else{
//            return redirect('nine/login');
//        }
//    }

//    发送验证码
    public function send()
    {
        $data=request()->input();
        $res=DB::table('nine')->where(['name'=>$data['name']])->first();
        if($res){
            if($data['pwd']==$res->pwd){
                $code=rand(0000,9999);
                $url='https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$this->tools->get_wechat_access_token();
                $data=[
                    'touser'=>$res->openid,
                    'template_id'=>'tSC9d2d7n-vgTFpk1ugENR280FPNG1AT4GwZhYOcoQw',
                    'data'=>[
                        'first'=>['value'=>'验证码'],
                        'keyword1'=>['value'=>$res->name],
                        'keyword2'=>['value'=>$code],
                        'keyword3'=>['value'=>date("Y-m-d H:i:s",time())],
                    ]
                ];
                $this->tools->curl_post($url,json_encode($data));
            }else{
                return json_encode(['msg'=>'账号或密码错误']);
            }
        }else{
            return json_encode(['msg'=>'账号或密码错误']);
        }
    }
    /*
    后台主页
    */
    public function index()
    {
//        echo 1;
        return view('nine.index');
    }
    public function index_v1()
    {
        return view('nine.index_v1');
    }

}
