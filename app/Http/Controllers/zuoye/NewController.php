<?php

namespace App\Http\Controllers\zuoye;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tools\Tools;
use App\model\NewModel;
use Illuminate\Support\Facades\Cache;
use DB;
use App\model\Wechat\VideoModel;
use App\Tools\Qiniu;
class NewController extends Controller
{
    public $tools;
    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }
    public function new()
    {
        $name=\request()->input('name');
        if(empty($name))
        {
            return json_encode(['ret'=>0,'msg'=>'请传查询的人'],JSON_UNESCAPED_UNICODE);
        }
        $url="http://api.avatardata.cn/ActNews/Query?key=3c458a7d3ee5421696c4e991b730958f&keyword={$name}";
        $data=$this->tools->httpCurl($url);
        $data=json_decode($data,1);
        if($data['result']==null)
        {
            return json_encode(['ret'=>0,'msg'=>'查询的没有这个人的新闻'],JSON_UNESCAPED_UNICODE);
        }
        foreach ($data['result'] as $v)
        {
            $res=NewModel::where(['title'=>$v['title']])->first();
            if(!$res)
            {
                NewModel::insert([
                    'title'=>$v['title'],
                    'content'=>$v['content'],
                    'pdate_src'=>$v['pdate_src'],
                    'src'=>$v['src'],
                    'pdate'=>$v['pdate'],
                ]);
            }
        }
        return $data;
    }
    public function newIndex()
    {
        $value = Cache::store('redis')->get('NewData');
        return view('zuoye.newindex',['value'=>$value]);
    }
    public function image()
    {
        $Ndata=DB::table('Navigation')->get();
        $play_data=DB::table('play')->get();
        $data=[
            ['img'=>"/images/swiper1.jpg",'name'=>'小花'],
            ['img'=>"/images/swiper2.jpg",'name'=>'三弟'],
            ['img'=>"/images/swiper3.jpg",'name'=>'弟弟'],
        ];
        echo json_encode(["data"=>$data,'Ndata'=>$Ndata,'play_data'=>$play_data]);
    }
    public function search()
    {
        $video_name=\request('video_name');
        if ($video_name=="")
        {
            echo json_encode(['code=>202','mussucc'=>'请传参数']);
        }else{
            $VideoData=VideoModel::where('video_name','like',"%$video_name%")->select('video_name')->get();
            echo json_encode(['code=>200','mussucc'=>'请传成功','data'=>$VideoData]);
        }

    }
    public function QiniuToken()
    {
        $token=Qiniu::token();
        return view('images.image',['token'=>$token]);
    }
}
