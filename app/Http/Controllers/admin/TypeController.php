<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\admin\CateModel;
use App\model\admin\GoodsModel;
use App\model\admin\TypeModel;
use App\model\admin\AttrModel;
class TypeController extends Controller
{
//    类型添加
    public function type_save()
    {
        return view('nine.admin.type.type_save');
    }
//    类型添加执行
    public function type_save_do()
    {
        $data=\request()->all();
        $res=TypeModel::insert([
            'type_name'=>$data['type_name']
        ]);
        if($res)
        {
            return redirect('nine/type_show');
        }else{
            return redirect('nine/type_save');
        }
    }
//    类型展示
    public function type_show()
    {
        $type_data=TypeModel::get();
        foreach($type_data as $k=>$v)
        {
            $type_data[$k]['attr_number']=AttrModel::where(['goods_type'=>$v->type_id])->count();
        }
        return view('nine.admin.type.type_show',['type_data'=>$type_data]);
    }
//    获取类型下的属性
    public function type_attr()
    {
        $attr_id=\request()->input('attr_id');
        $type_attr_data=AttrModel::where(['goods_type'=>$attr_id])->get();
        return json_encode(['type_attr_data'=>$type_attr_data]);
    }
}
