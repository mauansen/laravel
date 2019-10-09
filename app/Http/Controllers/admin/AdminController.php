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
        $code=request()->session()->get($res->openid);
        if($data['code']==""){
            return redirect('nine/login');
        }
        if($res && $data['code'] ==$code){
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
        $host = $_SERVER['HTTP_HOST'];  //域名
        $uri = $_SERVER['REQUEST_URI']; //路由参数
        if(!empty($req)){
            $result = file_get_contents('https://api.weixin.qq.com/sns/oauth2/access_token?appid='.env('WECHAT_APPID').'&secret='.env('SECRET').'&code='.$req['code'].'&grant_type=authorization_code');
            $re = json_decode($result,1);
            $user_info = file_get_contents('https://api.weixin.qq.com/sns/userinfo?access_token='.$re['access_token'].'&openid='.$re['openid'].'&lang=zh_CN');
            $wechat_user_info=json_decode($user_info,1);
            return view('nine.accout',['openid'=>$wechat_user_info['openid'],'nickname'=>$wechat_user_info['nickname']]);
        }else{
            $redirect_uri = urlencode("http://".$host.$uri);
            $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.env('WECHAT_APPID').'&redirect_uri='.$redirect_uri.'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
            header('Location:'.$url);
        }
    }
//    绑定账号执行
    public function accout_do()
    {
        $data=request()->except('_token');
        $res=DB::table('nine')->where(['name'=>$data['name']])->first();
        if($res){
            if($data['pwd']==$res->pwd){
                DB::table('nine')->where('id','=',$res->id)->update([
                    'openid'=>$data['openid'],
                    'nickname'=>$data['nickname']
                ]);
            }
        }
        return redirect('nine/login');
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
                request()->session()->put($res->openid,$code,300);
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
                return json_encode(['msg'=>'已发送验证码']);
            }else{
                return json_encode(['msg'=>'账号或密码错误']);
            }
        }else{
            return json_encode(['msg'=>'账号或密码错误']);
        }
    }
//    扫码登陆
    public function sweep()
    {
        $id=rand(0000,9999);
        $url="http://www.mayansen.cn/nine/code?id=".$id;
        return view('nine/image',['url'=>$url,'id'>$id]);
    }
    public function code()
    {
        $id=request()->all();
        $openid=$this->tools->openid();
        dd($openid);
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
//   练习试图
    public function lian()
    {

    }


}
