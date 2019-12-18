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
    /**
     * 申请聊天室
     */
    public function apply($username)
    {
        return view('swoole/apply',['username'=>$username]);
    }
    public function apply_do()
    {
        $post=\request()->except('_token');
//        dd($post);
        $res=DB::table('apply')->insert([
            'apply'=>$post['apply'],
            'identification'=>1
        ]);
        if ($res)
        {
            return view('swoole/show',['username'=>$post['username']]);
        }else{
            return view('swoole/show',['username'=>$post['username']]);
        }
    }
    /*
     * 申请列表
     */
    public function apply_list()
    {
        $data=DB::table('apply')->where(['identification'=>1])->get();
        return view('swoole/apply_list',['data'=>$data]);
    }
    /*
     * 直播
     */
    public function zhi()
    {
        return view('swoole/zhi');
    }
}
