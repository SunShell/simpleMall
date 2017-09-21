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
 * 后台产品相关路由
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

/*
 * 后台服务与支持相关路由
 */
//后台管理-问题列表
Route::get('/admin/service/issueList', 'ServiceController@issueList');
//后台管理-问题添加
Route::post('/admin/service/issueAdd', 'ServiceController@issueAdd');
//后台管理-获取问题
Route::post('/admin/service/issueGet', 'ServiceController@issueGet');
//后台管理-问题修改
Route::post('/admin/service/issueModify', 'ServiceController@issueModify');
//后台管理-问题删除
Route::post('/admin/service/issueDel', 'ServiceController@issueDel');
//后台管理-经销商列表
Route::get('/admin/service/vendorList', 'ServiceController@vendorList');
//后台管理-经销商添加
Route::post('/admin/service/vendorAdd', 'ServiceController@vendorAdd');
//后台管理-获取经销商
Route::post('/admin/service/vendorGet', 'ServiceController@vendorGet');
//后台管理-经销商修改
Route::post('/admin/service/vendorModify', 'ServiceController@vendorModify');
//后台管理-经销商删除
Route::post('/admin/service/vendorDel', 'ServiceController@vendorDel');

/*
 * 后台案例相关路由
 */
//后台管理-案例分类列表
Route::get('/admin/example/categoryList', 'ExampleController@categoryList');
//后台管理-案例分类添加
Route::post('/admin/example/categoryAdd', 'ExampleController@categoryAdd');
//后台管理-获取案例分类
Route::post('/admin/example/categoryGet', 'ExampleController@categoryGet');
//后台管理-获取全部案例分类
Route::post('/admin/example/categoryAll', 'ExampleController@categoryAll');
//后台管理-案例分类修改
Route::post('/admin/example/categoryModify', 'ExampleController@categoryModify');
//后台管理-案例分类删除
Route::post('/admin/example/categoryDel', 'ExampleController@categoryDel');
//后台管理-案例添加页
Route::get('/admin/example/add', 'ExampleController@add')->name('exampleAdd');
//后台管理-案例添加保存
Route::post('/admin/example/store', 'ExampleController@store');
//后台管理-案例列表页
Route::get('/admin/example/list', 'ExampleController@list')->name('exampleList');
//后台管理-案例保存
Route::post('/admin/example/store', 'ExampleController@store');
//后台管理-案例修改
Route::post('/admin/example/modify', 'ExampleController@modify');
//后台管理-案例修改保存
Route::post('/admin/example/storeModify', 'ExampleController@storeModify');
//后台管理-案例删除
Route::post('/admin/example/del', 'ExampleController@del');
