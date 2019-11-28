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
        $where=[];
        if($name!="")
        {
            $where[]=['music_name','like',"%$name%"];
            $where[]=['music_singer','like',"%$name%"];
        }
        $data=MusicModel::where($where)->get();
        return json_encode($data,JSON_UNESCAPED_UNICODE);
    }
    public function rotation()
    {
        $data=RotationModel::where(['is_enable'=>1])->get();
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
        $data=MusicModel::where(['music_cate_id'=>$id])->get();
        return json_encode($data,JSON_UNESCAPED_UNICODE);
    }
}
