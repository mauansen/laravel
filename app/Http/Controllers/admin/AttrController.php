<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\admin\CateModel;
use App\model\admin\GoodsModel;
use App\model\admin\TypeModel;
use App\model\admin\AttrModel;
class AttrController extends Controller
{
//    属性添加
    public function attr_save()
    {
        $type_data=TypeModel::get();
        return view('nine.admin.attr.attr_save',['type_data'=>$type_data]);
    }
//    属性添加执行
    public function attr_save_do()
    {
        $data=\request()->all();
        $res=AttrModel::insert([
            'attr_name'=>$data['attr_name'],
            'goods_type'=>$data['goods_type'],
            'is_attr'=>$data['is_attr']
        ]);
        if($res)
        {
            return redirect('nine/attr_show');
        }else{
            return redirect('nine/attr_save');
        }
    }
//    属性展示
    public function attr_show()
    {
        $type_data=TypeModel::get();
        $attr_data=AttrModel::join('type','attr.goods_type','=','type.type_id')->get();
        return view('nine.admin.attr.attr_show',['attr_data'=>$attr_data,'type_data'=>$type_data]);
    }
//    属性删除
    public function attr_del()
    {
        $attr_id=\request()->all();

    }
//    类型下的属性
    public function type_attr_show()
    {
        $type_id=request()->input('type_id');
        if($type_id == "0")
        {
            $type_attr=AttrModel::join('type','attr.goods_type','=','type.type_id')->get();
        }else{
            $type_attr=AttrModel::where('attr.goods_type','=',$type_id)->join('type', function ($join) {$join->on('attr.goods_type', '=', 'type.type_id');})->get();
        }
        return json_encode(['code'=>1,'msg'=>'ok','type_attr'=>$type_attr]);
    }
}
