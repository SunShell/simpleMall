<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Article;
use App\ArticleCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //新闻分类列表页
    public function categoryList()
    {
        return view('admin.dashboard.article.categoryList');
    }

    //新闻分类添加
    public function categoryAdd()
    {
        $categoryName = request('categoryName');

        $articleCategory = new ArticleCategory();

        $num = $articleCategory->where('name', $categoryName)->count();

        if($num > 0){
            return response()->json(array('flag'=> 'exist'), 200);
        }

        $userId = Auth::user()->userId;

        $res = $articleCategory->create([
            'name' => $categoryName,
            'addUser' => $userId
        ]);

        $flag = 'error';
        if($res) $flag = 'success';

        return response()->json(array('flag'=> $flag), 200);
    }

    //获取新闻分类信息
    public function categoryGet()
    {
        $categoryId = request('categoryId');

        $articleCategory = new ArticleCategory();
        $data = $articleCategory->where('id', $categoryId)->first();

        if($data){
            return response()->json(array('flag'=> 'success', 'data'=> $data), 200);
        }else{
            return response()->json(array('flag'=> 'error'), 200);
        }
    }

    //新闻分类修改
    public function categoryModify()
    {
        $categoryId = request('categoryId');
        $categoryName = request('categoryName');

        $articleCategory = new ArticleCategory();
        $num = $articleCategory->where('id','<>', $categoryId)->where('name', $categoryName)->count();

        if($num > 0){
            return response()->json(array('flag'=> 'exist'), 200);
        }

        $res = $articleCategory->where('id', $categoryId)->update([
            'name' => $categoryName
        ]);

        $flag = 'error';
        if($res) $flag = 'success';

        return response()->json(array('flag'=> $flag), 200);
    }

    //新闻分类删除
    public function categoryDel()
    {
        $delId = request('delId');

        $article = new Article();

        $num = $article->where('categoryId', $delId)->count();

        if($num > 0){
            return response()->json(array('flag'=> 'exist'), 200);
        }

        $articleCategory = new ArticleCategory();

        $res = $articleCategory->where('id', $delId)->delete();

        $flag = 'error';
        if($res) $flag = 'success';

        return response()->json(array('flag'=> $flag), 200);
    }

    //获取全部新闻分类
    public function categoryAll()
    {
        $articleCategory = new ArticleCategory();

        $res = $articleCategory->pluck('name', 'id');

        return response()->json(array('data'=> $res), 200);
    }

    //新闻添加页
    public function add()
    {
        $now = Carbon::now();
        $datePath = $now->year.'/'.$now->month.'/'.$now->day;

        if(session('addDatePath')) $datePath = session('addDatePath');

        $articleCategory = new ArticleCategory();
        $categoryData = $articleCategory->pluck('name', 'id');

        return view('admin.dashboard.article.add', compact('datePath', 'categoryData'));
    }

    //新闻添加保存
    public function store()
    {
        $category = request('pCategory');
        $name = request('pName');
        $abstract = request('pAbstract');
        $image = request('pImage');
        $content = request('pContent');
        $publishTime = request('pPublishTime');

        $article = new Article();

        $userId = Auth::user()->userId;

        $res = $article->create([
            'categoryId' => $category,
            'name' => $name,
            'abstract' => $abstract,
            'image' => $image,
            'content' => $content,
            'addUser' => $userId,
            'publishTime' => $publishTime
        ]);

        if($res){
            session()->flash('store_res', '添加成功！');

            return redirect()->route('articleAdd');
        }else{
            session()->flash('store_res', '添加失败！');

            return back();
        }
    }

    //新闻列表页
    public function list()
    {
        return view('admin.dashboard.article.list');
    }

    //新闻修改
    public function modify()
    {
        $modifyId = request('modifyId');

        $article = new Article();
        $data = $article->where('id', $modifyId)->first();
        session()->flash('articleData', $data);

        $addDate = new Carbon($data->created_at);
        session()->flash('addDatePath', $addDate->year.'/'.$addDate->month.'/'.$addDate->day);

        return redirect()->route('articleAdd');
    }

    //新闻修改保存
    public function storeModify()
    {
        $modifyId = request('modifyId');
        $category = request('pCategory');
        $name = request('pName');
        $abstract = request('pAbstract');
        $image = request('pImage');
        $content = request('pContent');
        $publishTime = request('pPublishTime');

        $article = new Article();

        $res = $article->where('id', $modifyId)->update([
            'categoryId' => $category,
            'name' => $name,
            'abstract' => $abstract,
            'image' => $image,
            'content' => $content,
            'publishTime' => $publishTime
        ]);

        if($res){
            session()->flash('store_res', '修改成功！');

            return redirect()->route('articleList');
        }else{
            session()->flash('store_res', '修改失败！');

            return back();
        }
    }

    //新闻删除
    public function del()
    {
        $ids = request('ids');

        $res = DB::delete("delete from articles where id in (".$ids.")");

        if($res){
            $res = 'success';
        }else{
            $res = 'error';
        }

        return response()->json(array('flag'=> $res), 200);
    }
}
