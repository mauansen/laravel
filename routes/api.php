<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::any('muisc','api\AdminController@muisc');
Route::any('rotation','api\AdminController@rotation');
Route::any('cate','api\AdminController@cate');
Route::any('cate_name','api\AdminController@cate_name');
//接口
Route::any('envet','PortController@envet');
