<?php

namespace App\model\admin;

use Illuminate\Database\Eloquent\Model;

class TypeModel extends Model
{
    protected $table="type";
    public $primaryKey="type_id";
    public $timestamps=false;
}
