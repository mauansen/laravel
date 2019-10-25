<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\ApiModel;
use DB;
use Illuminate\Support\Facades\Storage;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ApiModel=new ApiModel;
        $name=\request()->input('name');
        $where=[];
        if(isset($name))
        {
            $where[]=['name','like',"%$name%"];
        }

        $res=$ApiModel->where($where)->paginate(3);
        return json_encode(['code'=>1,'msg'=>'查询成功','data'=>$res]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name=request()->input('name');
        $age=request()->input('age');
        $tmp_name =request()->file('file');
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ApiModel=new ApiModel;
        $res=$ApiModel->find($id);
        $data=json_encode($res);
        return json_encode(['data'=>$res]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $name=request()->input('name');
        $age=request()->input('age');
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ApiModel=new ApiModel;
        $name=\request()->input('name');
        $where=[];
        if(isset($name))
        {
            $where[]=['name','like',"%$name%"];
        }
        $data=$ApiModel->where($where)->paginate(3);
        $res=$ApiModel->where('id','=',$id)->forceDelete();
        if($res)
        {
            return json_encode(['code'=>1,'msg'=>'删除成功','data'=>$data]);
        }else{
            return json_encode(['code'=>0,'msg'=>'删除失败']);
        }
    }
}
