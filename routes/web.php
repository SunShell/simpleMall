<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return 'test';
});

/*
 * 翻页相关路由
 */
//获取翻页信息和第一页数据
Route::post('/page/getPageInfo', 'PageController@getPageInfo');
//获取列表数据
Route::post('/page/getPage', 'PageController@getPage');

/*
 * 通用上传图片
 */
Route::post('/commonUploadImage', 'UploadController@commonUploadImage');

//后台登录页
Route::get('/admin/login', 'AdminSessionsController@create')->name('login');
//后台登录
Route::post('/admin/login', 'AdminSessionsController@store');
//后台登出
Route::get('/admin/logout', 'AdminSessionsController@destroy');
//默认home路由跳转
Route::get('/home', 'AdminsController@goIndex');
//后台管理首页
Route::get('/admin', 'AdminsController@index')->name('home');
//修改密码
Route::post('/admin/modifyPwd', 'AdminsController@modifyPwd');

/*
 * 后台产品管理相关路由
 */
//后台管理-产品类别列表
Route::get('/admin/product/categoryList', 'ProductController@categoryList');
//后台管理-产品类别添加
Route::post('/admin/product/categoryAdd', 'ProductController@categoryAdd');
//后台管理-产品类别删除
Route::post('/admin/product/categoryDel', 'ProductController@categoryDel');
//后台管理-产品类别获取某一条的信息
Route::post('/admin/product/categoryGet', 'ProductController@categoryGet');
//后台管理-产品类别修改
Route::post('/admin/product/categoryModify', 'ProductController@categoryModify');
//后台管理-产品类别获取
Route::post('/admin/product/categoryAll', 'ProductController@categoryAll');
//后台管理-产品参数设置
Route::get('/admin/product/configList', 'ProductController@configList');
//后台管理-产品参数添加
Route::post('/admin/product/configAdd', 'ProductController@configAdd');
//后台管理-产品参数修改
Route::post('/admin/product/configModify', 'ProductController@configModify');
//后台管理-产品参数删除
Route::post('/admin/product/configDel', 'ProductController@configDel');
//后台管理-产品添加
Route::get('/admin/product/add', 'ProductController@add')->name('productAdd');
//后台管理-产品添加保存
Route::post('/admin/product/store', 'ProductController@store');
//后台管理-产品列表
Route::get('/admin/product/list', 'ProductController@productList')->name('productList');;
//后台管理-产品删除
Route::post('/admin/product/del', 'ProductController@del');
//后台管理-产品修改
Route::post('/admin/product/modify', 'ProductController@modify');
//后台管理-文章修改保存
Route::post('/admin/product/storeModify', 'ProductController@storeModify');
