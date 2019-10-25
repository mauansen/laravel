<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\admin\UserModel;

class UserController extends Controller
{
    public function login()
    {
        $username=\request()->input('username');
        $pwd=\request()->input('pwd');
        $res=UserModel::where(['username'=>$username,'pwd'=>$pwd])->first();
        if($res)
        {
            $token=md5($res->user_id.time());
            $time=time()+7200;
            UserModel::where(['user_id'=>$res->user_id])->update([
                'token'=>$token,
                'Invalid_time'=>$time
            ]);
            return json_encode(['ret'=>1,'msg'=>'登陆成功','token'=>$token]);
        }else{
            return json_encode(['ret'=>'0','msg'=>'账号或密码不一致']);
        }

    }
    public function token()
    {
        $token=\request()->input('token');
        if (empty($token))
        {
            return json_encode(['ret'=>'0','msg'=>'请先登录'],JSON_UNESCAPED_UNICODE);
        }
        $res=UserModel::where(['token'=>$token])->first();
        if (empty($res))
        {
            return json_encode(['ret'=>'0','msg'=>'请先登录'],JSON_UNESCAPED_UNICODE);
        }
        if(time()>$res->Invalid_time)
        {
            return json_encode(['ret'=>'0','msg'=>'登陆过期'],JSON_UNESCAPED_UNICODE);
        }else{
            UserModel::where(['user_id'=>$res->user_id])->update([
                'Invalid_time'=>time()+7200
            ]);
        }
    }
}
