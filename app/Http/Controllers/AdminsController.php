<?php

namespace App\Http\Controllers;

use App\User;
use App\Product;
use App\Article;
use App\Example;
use App\SetMessage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //home路由跳转
    public function goIndex()
    {
        return redirect('/admin');
    }

    //后台首页
    public function index()
    {
        $product = new Product();
        $article = new Article();
        $example = new Example();
        $message = new SetMessage();

        $productNum = $product->count();
        $articleNum = $article->count();
        $exampleNum = $example->count();
        $messageNum = $message->count();

        $numObj = array(
            'productNum' => $productNum,
            'articleNum' => $articleNum,
            'exampleNum' => $exampleNum,
            'messageNum' => $messageNum
        );

        return view('admin.dashboard.index', compact('numObj'));
    }

    //修改密码
    public function modifyPwd()
    {
        $sp_userPwdOld = request('sp_userPwdOld');
        $sp_userPwdNew = request('sp_userPwdNew');

        if(!Hash::check($sp_userPwdOld, Auth::user()->password)) {
            return response()->json(array('flag'=> 'error', 'tip' => '旧密码输入不正确！'), 200);
        }

        $res = User::where('userId', Auth::user()->userId)->update([
            'password' => bcrypt($sp_userPwdNew)
        ]);

        if($res){
            return response()->json(array('flag'=> 'success', 'tip' => '修改成功！'), 200);
        }else{
            return response()->json(array('flag'=> 'error', 'tip' => '修改失败！'), 200);
        }
    }
}
