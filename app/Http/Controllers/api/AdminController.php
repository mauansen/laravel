<?php

namespace App\Http\Controllers\api;

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
use DB;

class AdminController extends Controller
{
    public $tools;
    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }
    public function muisc()
    {
        $name=\request()->input('value');
//        $where=[];
//        if($name!="")
//        {
//            $where[]=['music_name','like',"%$name%"];
//        }
        $where=[];
        $orwhere=[];
        if($name!="")
        {
            $where[]=['music_singer','like',"%$name%"];
            $orwhere[]=['music_name','like',"%$name%"];
        }
        $data=MusicModel::join('rotatio','rotatio.music_id','=','music.music_id')->where($where)->orWhere($orwhere)->get();
        return json_encode($data,JSON_UNESCAPED_UNICODE);
    }
    public function rotation()
    {
        $data=DB::table('rotatio')->join('music','rotatio.music_id','=','music.music_id')->where(['is_enable'=>1])->get();
        return json_encode($data,JSON_UNESCAPED_UNICODE);
    }
    public function cate()
    {
        $data=Music_cateModel::get();
        return json_encode($data,JSON_UNESCAPED_UNICODE);
    }
    public function cate_name()
    {
        $id=\request()->input('value');
        $data=MusicModel::join('rotatio','rotatio.music_id','=','music.music_id')->where(['music_cate_id'=>$id])->get();
        return json_encode($data,JSON_UNESCAPED_UNICODE);
    }
    //去微信调用MP3的音频
    public function music()
    {
        $id=\request()->input('id');

    }
}
