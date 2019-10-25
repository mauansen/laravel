<?php

namespace App\Http\Controllers\api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\ApiModel;
use DB;
class InterfaceContrroller extends Controller
{
    public function save()
    {
        $name=request()->input('name');
        $age=request()->input('age');
        $tmp_name =request()->file('file');
        dd($tmp_name);
        //文件夹名称
        $time =date('Y-n-j');
        //路径
        $path_sto =storage_path('app/public/image/'.$time);
        //创建文件夹
        if (!file_exists($path_sto)) {
            mkdir($path_sto);
        }
        Storage::put("image/".$time,$tmp_name);
        if ($name =="" || $age=="")
        {
              return json_encode(['code'=>0,'msg'=>'参数错误']);
        }
//        $res=DB::table('api')->insert([
//            'name'=>$name,
//            'age'=>$age,
//            'sex'=>$sex,
//            'add_time'=>time(),
//        ]);
        $ApiModel=new ApiModel;
        $ApiModel->name = $name;
        $ApiModel->age = $age;
        $ApiModel->add_time = time();
        $res=$ApiModel->save();
        if($res)
        {
            return json_encode(['code'=>1,'msg'=>'添加成功']);
        }else{
            return json_encode(['code'=>0,'msg'=>'添加错误']);
        }
    }
    public function show()
    {
        $ApiModel=new ApiModel;
        $res=$ApiModel->get();
        return json_encode(['code'=>1,'msg'=>'查询成功','data'=>$res]);
    }
    public function del()
    {
        $id=request()->input('id');
        $ApiModel=new ApiModel;
        $res=$ApiModel->where('id','=',$id)->forceDelete();
        if($res)
        {
            return json_encode(['code'=>1,'msg'=>'删除成功']);
        }else{
            return json_encode(['code'=>0,'msg'=>'删除成功']);
        }

    }
    public function update()
    {
        $id=request()->input('id');
        $ApiModel=new ApiModel;
        $res=$ApiModel->find($id);
        $data=json_encode($res);
        return json_encode(['data'=>$res]);
    }
    public function update_do()
    {
        $name=request()->input('name');
        $age=request()->input('age');
        $id=request()->input('id');
//        echo 123;
        if ($name =="" || $age=="" ||$id=="")
        {
            return json_encode(['code'=>0,'msg'=>'参数错误']);
        }
//        $res=DB::table('api')->insert([
//            'name'=>$name,
//            'age'=>$age,
//            'sex'=>$sex,
//            'add_time'=>time(),
//        ]);

        $res=DB::table('api')->where(['id'=>$id])->update([
            'name'=>$name,
            'age'=>$age
        ]);
        if($res)
        {
            return json_encode(['code'=>1,'msg'=>'修改成功']);
        }else{
            return json_encode(['code'=>0,'msg'=>'修改错误']);
        }
    }
    public function files($name)
    {
        if ( request()->file($name)->isValid()) {
            $photo = request()->file($name);
            $store_result = $photo->storage_path('public/image');
            return $store_result;
        }
    }
    public function examine()
    {
        $name=\request()->input('name');
        $age=\request()->input('age');
        $sign=\request()->input('sign');
        if($name==""||$age=="")
        {
            return json_encode(['ret'=>201,'msg'=>'参数没传'],JSON_UNESCAPED_UNICODE);
        }
        if($sign=="")
        {
            return json_encode(['ret'=>201,'msg'=>'签名不能为空'],JSON_UNESCAPED_UNICODE);
        }
        $masign=md5('1902'.$name.$age);
        if($masign!=$sign)
        {
            return json_encode(['ret'=>201,'msg'=>'签名不正确'],JSON_UNESCAPED_UNICODE);
        }
        return json_encode(['ret'=>001,'msg'=>'成功'],JSON_UNESCAPED_UNICODE);
    }
}
