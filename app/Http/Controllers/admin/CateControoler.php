<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\admin\CateModel;
use App\model\admin\GoodsModel;
use DB;
use Validator;

class CateControoler extends Controller
{
    public function cate_save()
    {
        $cate_data=CateModel::get();
        $cate_data=CreateTree($cate_data);
        return view('nine.admin.cate.cate_save',['cate_data'=>$cate_data]);
    }
    public function cate_save_do()
    {
        $validator=Validator::make(request()->all(),[
            'cate_name' => 'required|unique:cate',
        ],[
            'cate_name.required'=>"分类名称不能为空",
            'cate_name.unique'=>"分类名称已存在",
        ]);
        if ($validator->fails()) {
            return redirect('nine/cate_save')
                ->withErrors($validator)
                ->withInput();
        }
        $cate_data=\request()->all();
//        dd($cate_data);
        $res=CateModel::insert([
            'cate_name'=>$cate_data['cate_name'],
            'parent_id'=>$cate_data['parent_id']
        ]);
        if ($res)
        {
            return redirect('nine/cate_show');
        }else{
            return redirect('nine/cate_save');
        }
    }
    public function cate_show()
    {
        $cate_data=CateModel::get();
        foreach($cate_data as $k=>$v)
        {
            $cate_data[$k]['number']=GoodsModel::where(['cate'=>$v->cate_id])->count();
        }
        $cate_data=CreateTree($cate_data);
        return view('nine.admin.cate.cate_show',['cate_data'=>$cate_data]);
    }
//    唯一性
    public function only()
    {
        $cate_name=\request('cate_name');
        $res=CateModel::where(['cate_name'=>$cate_name])->first();
        if ($res !="")
        {
            return json_encode(['ret'=>1,'msg'=>'分类名称已存在']);
        }else{
            return json_encode(['ret'=>0,'msg'=>'分类名称不存在']);
        }
    }
}
