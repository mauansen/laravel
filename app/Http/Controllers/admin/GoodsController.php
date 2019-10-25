<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Validator;
use App\model\admin\CateModel;
use App\model\admin\GoodsModel;
use App\model\admin\TypeModel;
use App\model\admin\AttrModel;
use App\model\admin\Goods_attrModel;
use App\model\admin\StockModel;
class GoodsController extends Controller
{
//    商品添加
    public function goods_save()
    {
        $cate_data=CateModel::get();
        $type_data=TypeModel::get();
        return view('nine.admin.goods_save',['cate_data'=>$cate_data,'type_data'=>$type_data]);
    }
//    执行
    public function goods_save_do()
    {
        $validator=Validator::make(request()->all(),[
            'goods_name' => 'required',
            'price' => 'required|numeric',
            'cate' => 'required',
        ],[
            'goods_name.required'=>"商品名称不能为空",
            'price.required'=>"商品价格不能为空",
            'price.numeric'=>"商品价格是数字",
            'cate.required'=>"商品分类不能为空",
        ]);
        if ($validator->fails()) {
            return redirect('nine/goods_save')
                ->withErrors($validator)
                ->withInput();
        }
        $goods_data=\request()->except('_token');
        $time=date("Y-n-j");
        if(isset($goods_data['goods_img']))
        {
            $path=storage_path("app/public/nine/goods/".$time);
            if(!file_exists($path))
            {
                mkdir($path);
            }
            $goods_data['goods_img']="storage/".Storage::put("nine/goods/".$time,$goods_data['goods_img']);
        }else{
            $goods_data['goods_img']="0";
        }
        $goods_id=GoodsModel::insertGetId([
            'goods_name'=>$goods_data['goods_name'],
            'price'=>$goods_data['price'],
            'cate'=>$goods_data['cate'],
            'type_id'=>$goods_data['type_id'],
            'goods_img'=>$goods_data['goods_img'],
            'add_time'=>time(),
            'desc'=>$goods_data['desc'],
            'letm'=>$goods_data['letm'].time()
        ]);
        if(isset($goods_data['attr_value_list'])){
            $insert_data=[];
            foreach ($goods_data['attr_value_list'] as $key=>$value)
            {
                $insert_data[]=[
                    'goods_id'=>$goods_id,
                    'attr_id_list'=>$goods_data['attr_id'][$key],
                    'attr_value_list'=>$value,
                    'attr_price_list'=>$goods_data['attr_price_list'][$key],
                ];
            }
            $res=Goods_attrModel::insert($insert_data);
        }

        if($goods_id)
        {
            return redirect('nine/goods_stock_save/'.$goods_id);
        }else{
            return redirect('nine/goods_save');
        }
    }
    public function goods_show()
    {
        $goods_name=\request()->input('goods_name');
        $cate=\request()->input('cate');
        $where=[];
        if($goods_name){
            $where[]=['goods_name','like',"%$goods_name%"];
        };
        if($cate)
        {
            $where[]=['cate','=',$cate];
        };
        $goods_data=GoodsModel::join('cate','goods.cate','=','cate.cate_id')->join('type','goods.type_id','=','type.type_id')->where($where)->paginate(5);
        $cate_data=CateModel::get();
        return view('nine.admin.goods_show',['goods_data'=>$goods_data,'cate_data'=>$cate_data]);
    }
//    货品添加
    public function goods_stock_save($goods_id)
    {
        $goods_data=GoodsModel::where(['goods_id'=>$goods_id])->first();
        $data=Goods_attrModel::join('attr','goods_attr.attr_id_list','=','attr.attr_id')->where(['goods_id'=>$goods_id,'is_attr'=>1])->get()->toArray();
        $color = [];
        foreach ($data as $k => $v) {
            $attr_name=$v['attr_name'];
            $color[$attr_name][]=$v;
        }
        return view('nine/admin/goods_stock_save',['goods_data'=>$goods_data,'data'=>$color,'goods_id'=>$goods_id]);
    }
    public function goods_stock_save_do()
    {
        $postData=\request()->input();
//        $product_number=\request()->input('product_number');
//        if(!in_array('sku_attr_list',$postData))
//        {
//
//            $res=StockModel::insert([
//                'goods_id'=>$postData['goods_id'],
//                'sku_attr_list'=>implode(',',$postData['sku_attr_list']),
//                'product_number'=>implode(',',$product_number),
//            ]);
//        }else{
            $size=count($postData['sku_attr_list']) / count($postData['product_number']);
            $goods_attr=array_chunk($postData['sku_attr_list'],$size);
            foreach ($goods_attr as $k=>$v)
            {
                $res=StockModel::insert([
                    'goods_id'=>$postData['goods_id'],
                    'sku_attr_list'=>implode(',',$v),
                    'product_number'=>$postData['product_number'][$k]
                ]);
            }
//        }
        if($res)
        {
            return redirect('nine/goods_show');
        }else{
            return redirect('nine/goods_stock_save/'.$postData['goods_id']);
        }
    }
//    及点击该
    public function goods_that()
    {
        $goods_id=\request()->input('goods_id');
        $goods_name=\request()->input('goods_name');
        GoodsModel::where(['goods_id'=>$goods_id])->update([
            'goods_name'=>$goods_name
        ]);
    }
//    库存管理
    function stock_run()
    {
//        $stockData=GoodsModel::join('stock','stock.goods_id','=','goods.goods_id')->join('goods_attr', function ($join) {
//            $join->on('goods.goods_id', '=', 'goods_attr.goods_id')->wherein('goods_attr.goods_attr_id',explode(',','stock.sku_attr_list'));})->get()->toArray();
//        $stockData=StockModel::join('goods','stock.goods_id','=','goods.goods_id')->join('goods_attr', function ($join) {
//            $join->on('stock.goods_id', '=', 'goods_attr.goods_id')
//                ->wherein('goods_attr.goods_attr_id',explode(',','stock.sku_attr_list'));
//        })->get()->toArray();
//        foreach ($stockData as $v)
//        {
//            $goods_attr_id=explode(',',$v['sku_attr_list']);
//        }
//        dd($stockData);
    }
}
