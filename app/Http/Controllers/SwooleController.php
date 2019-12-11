<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SwooleController extends Controller
{
    public function index()
    {
        return view('swoole/index');
    }
}
