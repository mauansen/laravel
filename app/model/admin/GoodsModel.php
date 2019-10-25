<?php

namespace App\model\admin;

use Illuminate\Database\Eloquent\Model;

class GoodsModel extends Model
{
    protected $table="goods";
    public $primaryKey="goods_id";
    public $timestamps=false;
}
