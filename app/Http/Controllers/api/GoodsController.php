<?php

namespace App\Http\Controllers\Api;

use App\model\admin\UserModel;
use DemeterChain\C;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\model\admin\CateModel;
use App\model\admin\GoodsModel;
use App\model\admin\TypeModel;
use App\model\admin\AttrModel;
use App\model\admin\Goods_attrModel;
use App\model\admin\StockModel;
use App\model\admin\CartModel;
use Illuminate\Support\Facades\Cache;

class GoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *商品热销
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $goods=new Api_Goods_Model;
//        $goodsname=\request()->input('goodsname');
//        $city=\request()->input('city');
//        if($city=="")
//        {
//            $city="北京";
//        }
//        $where=[];
//        if(isset($goodsname))
//        {
//            $where[]=['goodsname','like',"%$goodsname%"];
//        }
//        $data=$goods->where($where)->paginate(3);
//        $weater=Cache::get('weaters_'.$city);
//        if ($weater=="")
//        {
//            $weater=file_get_contents("http://api.k780.com/?app=weather.realtime&weaid=".$city."&ag=today,futureDay,lifeIndex,futureHour&appkey=".env('APPKEY')."&sign=".env('Sign')."&format=json");
//            $weater=json_decode($weater,1);
//            $time=date("Y-m-d");
//            $time24=strtotime($time)+86400;
//            $cache_time=$time24 - time();
//            Cache::put('weaters_'.$city,$weater,$cache_time);
//        }
//        if ($data){
//            return json_encode(['code'=>1,'msg'=>'查询成功','data'=>$data,'weater'=>$weater]);
//        }else{
//            return json_encode(['code'=>0,'msg'=>'查询成功']);
//        }
        $data=GoodsModel::orderBy('goods_id','desc')->limit('4')->get();
//        foreach ($data as $v)
//        {
//
//        }
//        $url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
//        dd($url);
        return json_encode(['ret'=>1,'data'=>$data]);
    }
    /**
     * @return false|string
     */
//    加入购物车
    public function cart()
    {
//        接受中间件传过来的token
        $res = \request()->get('user');//中间件产生的参数
//        接受前台的传值
        $goods_id=\request()->input('goods_id');
        $goods_attr_id=implode(",",\request()->input('goods_attr_id'));
        $buy_number=1;
        $productData=StockModel::where(['goods_id'=>$goods_id,'sku_attr_list'=>$goods_attr_id])->first();
        if($buy_number>$productData['product_number'])
        {
            $is_have_num="0";
        }else{
            $is_have_num="1";
        }
        $CartData=CartModel::where(['goods_id'=>$goods_id,'goods_attr_id'=>$goods_attr_id,'user_id'=>$res->user_id])->first();
        if(!empty($CartData))
        {
            if($buy_number+$CartData['buy_number'] > $productData['product_number'])
            {
                $is_have_num="0";
            }else{
                $is_have_num="1";
            }
            $CartData->buy_number=$CartData->buy_number+$buy_number;
            $CartData->is_have_num;
            $resCar=$CartData->save();
        }else{
           $resCar=CartModel::insert([
                'user_id'=>$res->user_id,
                'goods_attr_id'=>$goods_attr_id,
                'goods_id'=>$goods_id,
                'buy_number'=>$buy_number,
                'product_id'=>$productData['stock_id'],
                'is_have_num'=>$is_have_num,
            ]);
        }
        if($resCar)
        {

            return json_encode(['ret'=>'1','msg'=>'加入购物车成功']);
        }
    }
//    购物车列表
    public function cart_show()
    {
        $res = \request()->get('user');
        $CartData=CartModel::join('goods','goods.goods_id','=','cart.goods_id')->where(['user_id'=>$res->user_id])->get()->toArray();
        foreach ($CartData as $k=>$v)
        {
            $goods_attr_id=explode(",",$v['goods_attr_id']);
            $GoodsAttrDate=Goods_attrModel::join('attr','attr.attr_id','=','goods_attr.attr_id_list')->where(['goods_id'=>$v['goods_id']])->whereIn('goods_attr_id',$goods_attr_id)->get()->toArray();
            $attr_value_list=[];
            $count_price=$v['price'];
            foreach ($GoodsAttrDate as $value)
            {
                    $attr_value_list[]=$value['attr_name'].":".$value['attr_value_list'];
                    $CartData[$k]['goods_attr_id']=implode(",",$attr_value_list);
                    $count_price +=$value['attr_price_list'];
            }
            $CartData[$k]['price']=$count_price;
        }
        if($CartData)
        {
            return json_encode(['ret'=>'1','cartData'=>$CartData]);
        }else{
            return json_encode(['ret'=>'0','msg'=>'你没有商品加入购物车']);
        }
    }
    //商品详情
    public function goods_details($goods_id)
    {
        $data=GoodsModel::find($goods_id)->toArray();
        GoodsModel::where(['goods_id'=>$goods_id])->update([
            'is_num'=>$data['is_num']+1,
        ]);
        $goods_attr_data=Goods_attrModel::join('attr','goods_attr.attr_id_list','=','attr.attr_id')->where(['goods_id'=>$goods_id])->get()->toArray();
        $parameter=[];
        $norms=[];
        foreach ($goods_attr_data as $key=>$value)
        {
           if($value['is_attr'] == 1)
           {
                   $status= $value['attr_name'];
                   $parameter[$status][]=$value;
           }else{
               $norms=$value;
           }
        }
        return json_encode(['data'=>$data,'norms'=>$norms,'parameter'=>$parameter]);
    }
    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=\request()->all();
//        dd($data);
        if($data['goodsname']=="" || $data['price']==""|| $data['image']=="")
        {
            return json_encode(['code'=>0,'msg'=>'添加出错']);
        }
        $imgae=$request->file('image');
        //文件夹名称
        $time =date('Y-n-j');
        //路径
        $path_sto =storage_path('app/public/image/'.$time);
        //创建文件夹
        if (!file_exists($path_sto)) {
            mkdir($path_sto);
        }
        $data['image']='storage/'.Storage::put("image/".$time,$imgae);
        $res=Api_Goods_Model::insert($data);
        if($res)
        {
            return json_encode(['code'=>1,'msg'=>'添加成功']);
        }else{
            return json_encode(['code'=>0,'msg'=>'添加出错']);
        }
    }



}
