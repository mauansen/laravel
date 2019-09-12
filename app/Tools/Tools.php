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
            $result = file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wxc82a04ef31eb2584&secret=666a5b097d1054dab68f81d3a48c978b');
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

}