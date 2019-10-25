<?php

namespace App\model\admin;

use Illuminate\Database\Eloquent\Model;

class Goods_attrModel extends Model
{
    protected $table="goods_attr";
    public $primaryKey="goods_attr_id";
    public $timestamps=false;
}
