<?php

namespace App\Http\Middleware;

use Closure;
use App\model\admin\UserModel;
class Token
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
//        校验token
        $token=$request->input('token');
        $user=$this->CkeckToken($token);
        $mid_params = ['user'=>$user];
        $request->attributes->add($mid_params);//添加参数
        return $next($request);
    }
    public function CkeckToken($token)
    {

        if(empty($token))
        {
            echo  json_encode(['ret'=>'0','msg'=>'请先登录'],JSON_UNESCAPED_UNICODE);die;
        }
        $res=UserModel::where(['token'=>$token])->first();
        if (empty($res))
        {
            echo json_encode(['ret'=>'0','msg'=>'请先登录1'],JSON_UNESCAPED_UNICODE);die;
        }
        if(time()>$res->Invalid_time)
        {
            echo json_encode(['ret'=>'0','msg'=>'登陆过期'],JSON_UNESCAPED_UNICODE);die;
        }else{
            UserModel::where(['user_id'=>$res->user_id])->update([
                'Invalid_time'=>time()+7200
            ]);
        }
        return $res;
    }
}
