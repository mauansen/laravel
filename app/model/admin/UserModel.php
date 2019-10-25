<?php

namespace App\model\admin;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $table="user";
    public $primaryKey="user_id";
    public $timestamps=false;
}
