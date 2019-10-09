<?php
namespace App\Tools;

class Tools {
    public $redis;
    public function __construct()
    {
        $this->redis = new \Redis();
        $this->redis->connect('127.0.0.1','6379');
    }
//    获取access_token
    public function get_wechat_access_token()
    {

//        //加入缓存
        if($this->redis->exists('wechat_access_token')){
            //存在
            return$this->redis->get('wechat_access_token');
        }else{
            //不存在
            $result = file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.env('WECHAT_APPID').'&secret='.env('SECRET'));
            $res = json_decode($result,1);
            $this->redis->set('wechat_access_token',$res['access_token'],7200);  //加入缓存
            return $res['access_token'];
        }
    }
//
    public function client_upload($url,$path,$client,$is_video=0,$title='',$desc=''){
        $multipart =  [
            [
                'name'     => 'media',
                'contents' => fopen($path, 'r')
            ]
        ];
        if($is_video == 1){
            $multipart[] = [
                'name'=>'description',
                'contents' => json_encode(['title'=>$title,'introduction'=>$desc],JSON_UNESCAPED_UNICODE)
            ];
        }
        $result = $client->request('POST',$url,[
            'multipart' => $multipart
        ]);
        return $result->getBody();
    }
//    curl
    public function curl_post($url,$data)
    {
//        curl的四部1初始化2设置请求3发送请求4关闭请求
        $curl = curl_init($url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_POST,true);  //发送post
        curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
        $data = curl_exec($curl);
        $errno = curl_errno($curl);  //错误码
        $err_msg = curl_error($curl); //错误信息
        curl_close($curl);
        return $data;
    }
    /**
     * jsapi_ticket
     * @return bool|string
     */
    public function get_wechat_jsapi_ticket()
    {
        //加入缓存
        if($this->redis->exists('wechat_jsapi_ticket')){
            //存在
            return $this->redis->get('wechat_jsapi_ticket');
        }else{
            //不存在
            $result = file_get_contents('https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='.$this->get_wechat_access_token().'&type=jsapi');
            $re = json_decode($result,1);
            $this->redis->set('wechat_jsapi_ticket',$re['ticket'],7200);  //加入缓存
            return $re['ticket'];
        }
    }
//    获取openid
    public function openid()
    {
        $req = request()->all();
        $host = $_SERVER['HTTP_HOST'];  //域名
        $uri = $_SERVER['REQUEST_URI']; //路由参数
        if(!empty($req)){
            $result = file_get_contents('https://api.weixin.qq.com/sns/oauth2/access_token?appid='.env('WECHAT_APPID').'&secret='.env('SECRET').'&code='.$req['code'].'&grant_type=authorization_code');
            $re = json_decode($result,1);
            $user_info = file_get_contents('https://api.weixin.qq.com/sns/userinfo?access_token='.$re['access_token'].'&openid='.$re['openid'].'&lang=zh_CN');
            $wechat_user_info=json_decode($user_info,1);
            return $wechat_user_info;
        }else{
            $redirect_uri = urlencode("http://".$host.$uri);
            $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.env('WECHAT_APPID').'&redirect_uri='.$redirect_uri.'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
            header('Location:'.$url);
        }
    }
    public static function getOpenid()
    {
        //echo 1;die;
        //先去session里取openid
        $openid = session('openid');
        //var_dump($openid);die;
        if(!empty($openid)){
            return $openid;
        }
        //微信授权成功后 跳转咱们配置的地址 （回调地址）带一个code参数
        $code = request()->input('code');
        if(empty($code)){
            //没有授权 跳转到微信服务器进行授权
            $host = $_SERVER['HTTP_HOST'];  //域名
            $uri = $_SERVER['REQUEST_URI']; //路由参数
            $redirect_uri = urlencode("http://".$host.$uri);  // ?code=xx
            $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".env('WECHAT_APPID')."&redirect_uri={$redirect_uri}&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect";
            header("location:".$url);die;
        }else{
            //通过code换取网页授权access_token
            $url =  "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".env('WECHAT_APPID')."&secret=".env('SECRET')."&code={$code}&grant_type=authorization_code";
            $data = file_get_contents($url);
            $data = json_decode($data,true);
            $openid = $data['openid'];
            //获取到openid之后  存储到session当中
            session(['openid'=>$openid]);
            return $openid;
            //如果是非静默授权 再通过openid  access_token获取用户信息
        }
    }
}