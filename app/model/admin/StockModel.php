<?php

namespace App\model\admin;

use Illuminate\Database\Eloquent\Model;

class StockModel extends Model
{
    protected $table="stock";
    public $primaryKey="stock_id";
    public $timestamps=false;
}
