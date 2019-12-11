<?php
namespace App\Http\Controllers\Xadmin;

use App\Tools\Tools;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\Xadmin\Xadmin_user;
use App\Tools\Code;
use Illuminate\Support\Facades\Cache;
use App\model\Xadmin\Music_cateModel;
use App\model\Xadmin\RotationModel;
use App\Tools\Qiniu;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use App\model\Xadmin\MusicModel;
class AdminController extends Controller
{
    public $tools;
    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 登陆
     */
    public function login()
    {
        return view('Xadmin/login');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * 登陆执行
     */
    public function login_do()
    {
        $data=request()->except('_token');
        $code=Cache::get('code');
        if ($code != $data['code'])
        {
            header("refresh:1;url=http://w3.la.cn/music/login"); print('<script >alert("验证码错误")</script>');die;
        }
        $user_data=Xadmin_user::where(['username'=>$data['username'],'password'=>$data['password']])->first();
        if (is_null($user_data))
        {
            header("refresh:1;url=http://w3.la.cn/music/login"); print('<script >alert("密码或者账号错误")</script>');die;
        }else{
            return redirect('music/index');
        }
    }
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 首页展示
     */
    public function index()
    {
        return view('Xadmin/index');
    }
    /**
     * 验证码
     */
    public function code()
    {
        $code=new Code(4, 1, 50, 100);
        $codes=$code->getCode();
        $code->outImage();
        Cache::put('code',$codes,360);
    }
    /*
     * 音乐添加
     */
    public function add()
    {
        $music_cate_data=Music_cateModel::get();
        return view('Xadmin/music_add',['music_cate_data'=>$music_cate_data]);
    }
    /*
     * 执行
     */
    public function music_add_do(Client $client)
    {
        $data=\request()->except('_token');
        $url="https://api.weixin.qq.com/cgi-bin/material/add_material?access_token=".$this->tools->get_wechat_access_token().'&type=voice';
        $ext = request()->file('music')->getClientOriginalExtension();  //文件类型
        $file_name = time().rand(1000,9999).'.'.$ext;
        $path = request()->file('music')->storeAs('music',$file_name);
        $storage_path = '/storage/'.$path;
        $paths = realpath('./storage/'.$path);
        $result=$this->tools->client_upload($url,$paths,$client);
        $media_id=json_decode($result,1);
        $music=$media_id['media_id'];
        $id=MusicModel::insertGetId([
            'music_name'=>$data['music_name'],
            'music_singer'=>$data['music_singer'],
            'music_cate_id'=>$data['music_cate_name'],
            'music'=>$music,
            'path'=>'http://w3.la.cn'.$storage_path
        ]);
        $a=$this->rotatio_add_do(curl_file_create($data['file']),$id);
        return redirect('music/show');
    }
    /*
     * 音乐列表
     */
    public function show()
    {
        $data=MusicModel::join('music_cate','music.music_cate_id','=','music_cate.cate_id')->get();
        return view('Xadmin/music_show',['data'=>$data]);

    }
    /**
     * 音乐分类
     */
    public function music_cate()
    {
        return view('Xadmin/music_cate');
    }
    /*
     * 分类添加执行
     */
    public function music_cate_do()
    {
        $data=\request()->except('_token');
        if ($data['music_cate_name']=="")
        {
            dd("音乐分类不能为空");
        }
        Music_cateModel::insert($data);
        return redirect('music/music_cate_list');
    }
    /*
     * 分类展示
     */
    public function music_cate_list()
    {
        $data=Music_cateModel::get();
        return view('Xadmin/music_cate_list',['data'=>$data]);
    }
    /*
     * 分类删除
     */
    public function music_del()
    {
        $cate_id=\request()->input('cate_id');
        Music_cateModel::where(['cate_id'=>$cate_id])->delete();
        return redirect('music/music_cate_list');
    }
    /*
     * 分类修改
     */
    public function music_up()
    {
        $cate_id=\request()->input('cate_id');
        $data=Music_cateModel::where(['cate_id'=>$cate_id])->first();
        return view('Xadmin/music_save',['data'=>$data]);
    }
    //分类修改执行
    public function music_save()
    {
        $data=\request()->except('_token');
        if ($data['music_cate_name']=="")
        {
            dd("音乐分类不能为空");
        }
        Music_cateModel::where(['cate_id'=>$data['cate_id']])->update($data);
        return redirect('music/music_cate_list');
    }
    /*
     * 轮播图添加
     */
//    public function rotatio_add()
//    {
//
//        return view('Xadmin/rotatio_add');
//    }
    public function rotatio_add_do($file,$id)
    {
//        $file=curl_file_create(\request()->file('file'));
//        $title=\request()->input('title');
        $url="http://upload-z1.qiniup.com/";
        $token=Qiniu::token();
        $data=[
            'token'=>$token,
            'file'=>$file,
        ];
        $result=$this->tools->curl_from($url,$data);
        $img=json_decode($result,1);
        RotationModel::insert([
            'rotatio'=>'http://q0j02rf5k.bkt.clouddn.com/'.$img['key'],
            'is_enable'=>'2',
            'music_id'=>$id
        ]);
    }
    /*
     * 轮播图展示
     */
    public function rotatio_list()
    {
        $data=RotationModel::where(['is_enable'=>1])->get();
        return view('Xadmin/rotatio_list',['data'=>$data]);
    }
    /*
     * 轮播图删除
     */
    public function rotatio_del()
    {
        $id=\request()->input('rotatio_id');
        RotationModel::where(['rotatio_id'=>$id])->update([
            'is_enable'=>2
        ]);
        return redirect('music/rotatio_list');
    }
    /*
     * 轮播图的启用
     */
    public function rotatio_enable()
    {
        $rotatio_id=\request()->input('rotatio_id');
        RotationModel::where(['rotatio_id'=>$rotatio_id])->update([
            'is_enable'=>'1',
        ]);
        return redirect('music/rotatio_list');
    }
    public function button()
    {
        $postdata['button'][]=[
            'type'=>'miniprogram',
            'name'=>'首页',
            'url' =>'http://mp.weixin.qq.com',
            'appid'=>'wx73f25e5b5f2bdef3',
            'pagepath'=>'pages/index/index'
        ];
        $url="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$this->tools->get_wechat_access_token();
        $datas=$this->tools->curl_from($url,json_encode($postdata));
        dd(json_decode($datas,1));
    }
}
