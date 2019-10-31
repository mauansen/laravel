<?php

namespace App\Http\Controllers\zuoye;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tools\Tools;
use App\model\NewModel;
use Illuminate\Support\Facades\Cache;

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
            return json_encode(['ret'=>0,'msg'=>'请传查询的人']);
        }
        $url="http://api.avatardata.cn/ActNews/Query?key=3c458a7d3ee5421696c4e991b730958f&keyword={$name}";
        $data=$this->tools->httpCurl($url);

        $data=json_decode($data,1);
        if($data['error_code']!='0')
        {
            return json_encode(['ret'=>0,'msg'=>'查询的没有这个人的新闻']);
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
}
