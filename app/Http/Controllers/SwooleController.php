<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class SwooleController extends Controller
{
    public function index()
    {
        $res='';
        return view('swoole/index',['res'=>$res]);
    }
    public function login()
    {
        return view('swoole/login');
    }
    public function login_do()
    {
        $post=\request()->except('_token');
        $res=DB::table('user')->where(['username'=>$post['username'],'pwd'=>$post['pwd']])->first();
        $res=$res->username;
        if($res){
            return view('swoole/index',['res'=>$res]);
        }
    }
}
