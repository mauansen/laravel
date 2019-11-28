<?php
//=====================考试----
Route::prefix('music')->group(function () {
    Route::get('login','Xadmin\AdminController@login');
    Route::post('login_do','Xadmin\AdminController@login_do');
    Route::get('add','Xadmin\AdminController@add');
    Route::get('index','Xadmin\AdminController@index');
    Route::get('show','Xadmin\AdminController@show');
    Route::get('code','Xadmin\AdminController@code');
    Route::get('music_cate','Xadmin\AdminController@music_cate');
    Route::post('music_cate_do','Xadmin\AdminController@music_cate_do');
    Route::post('music_add_do','Xadmin\AdminController@music_add_do');
    Route::get('music_cate_list','Xadmin\AdminController@music_cate_list');
    Route::get('music_del','Xadmin\AdminController@music_del');
    Route::get('music_up','Xadmin\AdminController@music_up');
    Route::post('music_save','Xadmin\AdminController@music_save');
    Route::get('rotatio_add','Xadmin\AdminController@rotatio_add');//轮播图添加
    Route::post('rotatio_add_do','Xadmin\AdminController@rotatio_add_do');//轮播图添加
    Route::get('rotatio_list','Xadmin\AdminController@rotatio_list');//轮播图展示
    Route::get('rotatio_enable','Xadmin\AdminController@rotatio_enable');//轮播图展示
    Route::get('button','Xadmin\AdminController@button');//轮播图展示
});
//====================考试----
//第九个月接口
//前台登陆
Route::get('api/goods_show','api\GoodsController@index')->middleware('apilogin');//商品热销页面
Route::get('api/goods_details/{goods_id}','api\GoodsController@goods_details')->middleware('apilogin');//商品详情页面
Route::prefix('api')->middleware('apilogin')->group(function (){
    Route::get('token','admin\UserController@token');//token
    Route::get('login','admin\UserController@login');//拥有登陆
    Route::middleware('token')->group(function (){//验证token的中间件
        Route::get('cart','api\GoodsController@cart');//加入购物车
        Route::get('cart_show','api\GoodsController@cart_show');//购物车列表
    });
});

//考试
Route::get('new/new','zuoye\NewController@new')->middleware('apilogin');//测试
Route::get('new/newIndex','zuoye\NewController@newIndex')->middleware('apilogin');//测试
Route::get('new/image','zuoye\NewController@image');//测试
Route::get('new/search','zuoye\NewController@search');//测试
Route::get('new/QiniuToken','zuoye\NewController@QiniuToken');//测试


Route::get('api/examine','api\InterfaceContrroller@examine');//测试
Route::get('class/index','ClassController@index');//数据库处理
Route::get('class/aes_decrypt','ClassController@aes_decrypt');//加密解密aes
Route::get('class/rsa','ClassController@rsa');//加密解密rsa
Route::get('class/new','ClassController@new');//加密解密rsa
//后台登陆
Route::get('nine/login','admin\AdminController@login');//后台登陆页面
Route::post('nine/login_int','admin\AdminController@login_int');//后台登陆执行
Route::prefix('nine')->group(function (){
    Route::get('index','admin\AdminController@index');//后台主页
    Route::get('goods_save','admin\GoodsController@goods_save');//商品添加
    Route::post('goods_stock_save_do','admin\GoodsController@goods_stock_save_do');//货品添加
    Route::get('goods_stock_save/{goods_id}','admin\GoodsController@goods_stock_save');//商品库存添加
    Route::post('goods_save_do','admin\GoodsController@goods_save_do');//商品添加执行
    Route::get('goods_show','admin\GoodsController@goods_show');//商品展示
    Route::get('goods_that','admin\GoodsController@goods_that');//商品名称及点击该
    Route::get('stock_run','admin\GoodsController@stock_run');//商品库存管理
    Route::get('cate_show','admin\CateControoler@cate_show');//分类展示
    Route::get('cate_save','admin\CateControoler@cate_save');//分类添加
    Route::post('cate_save_do','admin\CateControoler@cate_save_do');//分类添加执行
    Route::get('only','admin\CateControoler@only');//分类唯一性
    Route::get('type_save','admin\TypeController@type_save');//类型添加
    Route::post('type_save_do','admin\TypeController@type_save_do');//类型添加执行
    Route::get('type_show','admin\TypeController@type_show');//类型展示
    Route::get('attr_save','admin\AttrController@attr_save');//属性添加
    Route::get('attr_show','admin\AttrController@attr_show');//属性展示
    Route::get('type_attr_show','admin\AttrController@type_attr_show');//类型下的属性展示
    Route::post('attr_save_do','admin\AttrController@attr_save_do');//属性添加执行
    Route::get('type_attr','admin\TypeController@type_attr');//获取类型下的属性

    Route::get('index_v1','admin\AdminController@index_v1');
    Route::get('send','admin\AdminController@send');
    Route::get('accout','admin\AdminController@accout');
    Route::post('accout_do','admin\AdminController@accout_do');
    Route::get('sweep','admin\AdminController@sweep');
    Route::get('code','admin\AdminController@code');
    Route::get('openid','admin\AdminController@openid');
    Route::get('checkLogin','admin\AdminController@checkLogin');
});
//restful风格
//Route::resource('api/user', 'api\PostController');
//Route::resource('api/goods', 'api\GoodsController');
//商品添加
Route::get('goods/save',function (){
    return view('goods.save');
});
//商品展示
Route::get('goods/goods_show',function (){
    return view('goods.goods_show');
});
//前端
Route::get('nine/apiadd',function (){
    return view('nine.apiadd');
});
Route::get('nine/show',function (){
    return view('nine.show');
});
Route::get('nine/update',function (){
    return view('nine.update');
});
//接口
//Route::prefix('api')->group(function (){
//   Route::get('add','api\InterfaceContrroller@save');
//   Route::get('show','api\InterfaceContrroller@show');
//   Route::get('del','api\InterfaceContrroller@del');
//   Route::get('update','api\InterfaceContrroller@update');
//   Route::get('update_do','api\InterfaceContrroller@update_do');
//});

//
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//练习
Route::get('studen/add', 'UserController@studen');
Route::post('studen/studenadd_do', 'UserController@studenadd_do')->name('do');
Route::get('studen/lists', 'UserController@lists');
Route::get('studen/mali', 'MailController@index');
// 考试学生
Route::get('studen/save', 'StudentController@save');
Route::post('studen/save_do', 'StudentController@save_do');
Route::get('studen/index', 'StudentController@index');
Route::get('studen/del/{id}', 'StudentController@del');
Route::get('studen/up/{id}', 'StudentController@up');
Route::post('studen/up_do/{id}', 'StudentController@up_do');
// 后台
Route::prefix('admin')->middleware('checklogin')->group(function () {
    // 考试货物
    Route::get('cargoadd', 'CargoController@cargosave');
    Route::post('cargoadd_do', 'CargoController@cargosave_do');
    Route::get('catgoindex', 'CargoController@catgoindex');
    Route::get('cargoup/{id}', 'CargoController@cargoup');
    Route::post('cargoupdate/{id}', 'CargoController@cargoupdate');
    Route::get('daily', 'CargoController@daily');
    Route::get('index', 'UserController@index');
    Route::get('head', 'UserController@head')->name('head');
    Route::get('foot', 'UserController@foot')->name('foot');
    Route::get('left', 'UserController@left')->name('left');
    Route::get('main', 'UserController@main')->name('main');
    // 管理员
    Route::get('useradd', 'UserController@useradd')->name('useradd');
    Route::post('useradd_do', 'UserController@useradd_do')->name('useradd_do');
    // 商品
    Route::get('goods', 'GoodsController@goods')->name('goods');
    Route::post('admin/goods_do', 'GoodsController@goods_do')->name('goods_do');
    Route::get('goods_list', 'GoodsController@goods_list')->name('goods_list');
    Route::get('goods_edit/{gid}', 'GoodsController@goods_edit');
    Route::post('goods_update/{gid}', 'GoodsController@goods_update');
    Route::get('goods_delete', 'GoodsController@goods_delete');
    // 分类
    Route::get('category', 'CatController@category')->name('category');
    Route::post('category_do', 'CatController@category_do')->name('category_do');
    Route::get('category_list', 'CatController@category_list')->name('category_list');
    // 品牌
    Route::get('brand', 'BrandController@brand')->name('brand');
    Route::post('brand_do', 'BrandController@brand_do')->name('brand_do');
    Route::get('brand_list', 'BrandController@brand_list')->name('brand_list');
    // 网站
    Route::get('site', 'SiteController@site')->name('site');
    Route::post('site_do', 'SiteController@site_do')->name('site_do');
    Route::get('site_list', 'SiteController@site_list')->name('site_list');
    Route::get('site_del', 'SiteController@site_del');
    Route::get('site_edit/{sid}', 'SiteController@site_edit');
    Route::post('site_update/{sid}', 'SiteController@site_update');
    Route::get('only', 'SiteController@only');
    // 新闻管理
    Route::get('newindex', 'NewsController@index');
    Route::get('add', 'NewsController@add');
    Route::post('add_do', 'NewsController@add_do');
    Route::get('address/{id}', 'NewsController@address');
    Route::get('dian', 'NewsController@dian');
    Route::get('qu', 'NewsController@qu');
});
// 登陆
Route::get('login_del', 'LoginController@login_del')->name('login_del');
Route::get('login', 'LoginController@login');
Route::post('login_do', 'LoginController@login_do')->name('login_do');
// 前台
Route::get('/', 'IndexController@index');
Route::get('index/login', 'LoginController@index');
Route::post('index/login_do', 'LoginController@index_do');
Route::get('/reg', 'LoginController@reg');
Route::post('/reg_do', 'LoginController@reg_do');
Route::get('/email', 'LoginController@email');
// 商品展示
Route::get('/goods', 'GoodsController@goodslist');
// 商品详情页
Route::get('index/proinfo_index/{gid}', 'ProinfoController@proinfo_index');
// 所以商品展示
Route::get('index/prolist/{cid}', 'ProlistController@prolist');
// 购物车
Route::get('index/car_index', 'GarController@car_index');
//    微信第三方登陆
Route::get('index/code', 'LoginController@code');
Route::get('index/wechat_login', 'LoginController@wechat_login');
//    微信公众号
Route::get('index/get_user_list', 'WeixinController@get_user_list');//微信用户列表
Route::get('index/get_access_token', 'WeixinController@get_access_token');//获取access_token
Route::get('index/get_wechat_access_token', 'WeixinController@get_wechat_access_token');//
//微信内文件上传
Route::get('index/image', 'WeixinController@uplode');//微信上传图片
Route::post('index/image_do', 'WeixinController@uplode_do');//
Route::get('index/uplode_list', 'WeixinController@uplode_list');
Route::get('index/sidebar', 'WeixinController@sidebar');
Route::get('index/clear_api', 'WeixinController@clear_api');
//微信用户标签
Route::get('index/tog_list', 'TagController@tog_list');//标签列表
Route::get('index/tog_save', 'TagController@tog_save');
Route::post('index/tog_do', 'TagController@tog_do');
Route::get('index/tagdel/{id}', 'TagController@tagdel');
Route::get('index/tagup', 'TagController@tagup');
Route::post('index/tagup_do', 'TagController@tagup_do');
Route::post('index/tag_souer', 'TagController@tag_souer');
Route::get('index/user_tag', 'TagController@user_tag');
Route::get('index/tag_send', 'TagController@tag_send');//根据标签群法给用户
Route::post('index/tag_send_do', 'TagController@tag_send_do');
Route::get('index/getidlist', 'TagController@getidlist');
Route::get('index/fomwork', 'TagController@fomwork');
//文件上传
Route::get('index/uplode', 'StudentController@uplode');
Route::post('index/uplode_do', 'StudentController@uplode_do');
//微信周考
Route::get('practise/login', 'GroupController@login');
Route::get('practise/wechat_login', 'GroupController@wechat_login');
Route::get('practise/code', 'GroupController@code');
Route::prefix('practise')->middleware('practise')->group(function () {
    Route::get('user_tag', 'GroupController@user_tag');
    Route::post('send', 'GroupController@send');
});
//生成二维码
Route::get('index/qrcode_list', 'QrcodeContronller@qrcode_list');
Route::get('index/qrcode', 'QrcodeContronller@qrcode');
//生成菜单
Route::get('index/menu','MenuController@menu');
Route::get('index/menu_list','MenuController@menu_list');
Route::post('index/create_menu','MenuController@create_menu');
Route::get('index/menu_del','MenuController@menu_del');
//微信获取地理位置
Route::get('index/location','MenuController@location');//get_wechat_jsapi_ticket
//9-20的作也
Route::get('zuo/login','zuoye\CrontabController@login');
Route::post('zuo/login_do','zuoye\CrontabController@login_do');
Route::get('zuo/wechat','zuoye\CrontabController@wechat');
Route::get('zuo/code','zuoye\CrontabController@code');
