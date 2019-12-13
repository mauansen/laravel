<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class SwooleController extends Controller
{
    /**
     * 注册
     */
    public function register()
    {
        return view('swoole/register');
    }
    public function register_do()
    {
        $post=\request()->except('_token');
        $res=DB::table('user')->insert([
            'username'=>$post['username'],
            'pwd'=>$post['pwd']
        ]);
        if($res){
            return view('swoole/login',['res'=>$res]);
        }
    }
    public function index($res)
    {
        return view('swoole/index',['res'=>$res]);
    }
    public function cf($res)
    {
        return view('swoole/cf',['res'=>$res]);
    }
    public function dnf($res)
    {
        return view('swoole/cf',['res'=>$res]);
    }
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 登录
     */
    public function login()
    {
        return view('swoole/login');
    }
    public function login_do()
    {
        $post=\request()->except('_token');
        $res=DB::table('user')->where(['username'=>$post['username'],'pwd'=>$post['pwd']])->first();
//        $this->index($res->username);
        if($res)
        {
            return view('swoole/show',['username'=>$res->username]);
        }

    }
}
