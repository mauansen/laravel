<?php
namespace App\model;

use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    protected $table="class";
    public $primaryKey="class_id";
    public $timestamps=false;
}
