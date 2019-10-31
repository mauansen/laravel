<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class NewModel extends Model
{
    protected $table="new";
    public $primaryKey="new_id";
    public $timestamps=false;
}
