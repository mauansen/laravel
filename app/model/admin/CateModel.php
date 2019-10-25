<?php

namespace App\model\admin;

use Illuminate\Database\Eloquent\Model;

class CateModel extends Model
{
    protected $table="cate";
    public $primaryKey="cate_id";
    public $timestamps=false;
}
