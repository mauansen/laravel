<?php

namespace App\model\admin;

use Illuminate\Database\Eloquent\Model;

class AttrModel extends Model
{
    protected $table="attr";
    public $primaryKey="attr_id";
    public $timestamps=false;
}
