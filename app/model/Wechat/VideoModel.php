<?php

namespace App\model\Wechat;

use Illuminate\Database\Eloquent\Model;

class VideoModel extends Model
{
    protected $table = 'video';
    public $primaryKey="video_id";
    public $timestamps = false;
}
