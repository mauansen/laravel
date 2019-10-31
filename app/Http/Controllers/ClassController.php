<?php

namespace App\Http\Controllers;

use App\Tools\Tools;
use Illuminate\Http\Request;
use DB;
use App\model\ClassModel;
use App\Tools\Aes;
use App\Tools\Rsa;
use App\model\NewModel;
class ClassController extends Controller
{
    public $tools;
    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }
    public function index()
    {
        $ClassData=ClassModel::get();
        foreach ($ClassData as $k=>$v)
        {
            $ClassData[$k]['number']= DB::table('student')->where(['class_id'=>$v->class_id])->count();
        }
        foreach ($ClassData as $k=>$v)
        {
            $ClassData[$k]['news']= DB::table('student')->where(['class_id'=>$v->class_id])->get();
            $student=$ClassData;
        }
        return view('zuoye.index',['ClassData'=>$ClassData,'student'=>$student]);
    }
    public function aes_decrypt()
    {
        $key=env('AES_KEY');
        $obj=new Aes($key);
        $data="小黄吃屎";
        $res=$obj->encrypt($data);
        $resj=$obj->decrypt($res);
        dump($resj);
        dd($res);
    }
    public function rsa()
    {
        $Rsa=new Rsa();
        $privkey=file_get_contents('reskey/cert_private.pem');
        $pubkey=file_get_contents('reskey/cert_public.pem');
        $Rsa->init($privkey, $pubkey,TRUE);
        $encode=$Rsa->priv_encode('小黄吃屎');
        $decode=$Rsa->pub_decode($encode);
        dump($decode);
        dd($encode);
    }
    //第9月的月考题新闻
    public function new()
    {
        $name=[
            0=>"奥巴马",
            1=>"普京",
            2=>"特朗普",
            3=>"马克龙",
            4=>"比尔盖茨",
            5=>"特雷莎",
            6=>"克拉克",
            7=>"默克尔",
            8=>"福田康夫",
            9=>"马哈蒂尔",
        ];
        $data=[];
        foreach ($name as $v)
        {
            $url="http://api.avatardata.cn/ActNews/Query?key=3c458a7d3ee5421696c4e991b730958f&keyword={$v}";
            $new=$this->tools->httpCurl($url);
            $data[]=json_decode($new,1);
        }
        foreach ($data as $v)
        {
            foreach ($v['result'] as $key=>$value)
            {
                NewModel::insert([
                    'title'=>$value['title'],
                    'content'=>$value['content'],
                    'pdate'=>$value['pdate'],
                    'src'=>$value['src'],
                    'pdate_src'=>$value['pdate_src'],
                ]);
            }
        }
    }
}
