<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;
class Apilogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $ip=$_SERVER['REMOTE_ADDR'];//获取用户的IP地址
        $cacheName="pass_time".$ip;
        $num=Cache::get($cacheName);//把用户的IP取出
        //判断用户是否有登陆
        if(!$num)
        {
            $num="0";
        }
        //判断用户超过20 怀疑用非法强刷
        if($num>5)
        {
            echo json_encode(['ret'=>'0','msg'=>'您一天之能调用5次'],JSON_UNESCAPED_UNICODE);die;
        }
        $num+="1";
//        存入用户IP跟时间和次数
        Cache::put($cacheName,$num,60);
        return $next($request);
    }
}
