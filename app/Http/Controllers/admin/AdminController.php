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
        echo 1;
    }
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
                    'touser'=>'o5TRIs5L3naN6dSDtMwDTkjVsqlI',
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
