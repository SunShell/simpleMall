<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Example;
use App\ExampleCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExampleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //案例分类列表页
    public function categoryList()
    {
        return view('admin.dashboard.example.categoryList');
    }

    //案例分类添加
    public function categoryAdd()
    {
        $categoryName = request('categoryName');

        $exampleCategory = new ExampleCategory();

        $num = $exampleCategory->where('name', $categoryName)->count();

        if($num > 0){
            return response()->json(array('flag'=> 'exist'), 200);
        }

        $userId = Auth::user()->userId;

        $res = $exampleCategory->create([
            'name' => $categoryName,
            'addUser' => $userId
        ]);

        $flag = 'error';
        if($res) $flag = 'success';

        return response()->json(array('flag'=> $flag), 200);
    }

    //获取案例分类信息
    public function categoryGet()
    {
        $categoryId = request('categoryId');

        $exampleCategory = new ExampleCategory();
        $data = $exampleCategory->where('id', $categoryId)->first();

        if($data){
            return response()->json(array('flag'=> 'success', 'data'=> $data), 200);
        }else{
            return response()->json(array('flag'=> 'error'), 200);
        }
    }

    //案例分类修改
    public function categoryModify()
    {
        $categoryId = request('categoryId');
        $categoryName = request('categoryName');

        $exampleCategory = new ExampleCategory();
        $num = $exampleCategory->where('id','<>', $categoryId)->where('name', $categoryName)->count();

        if($num > 0){
            return response()->json(array('flag'=> 'exist'), 200);
        }

        $res = $exampleCategory->where('id', $categoryId)->update([
            'name' => $categoryName
        ]);

        $flag = 'error';
        if($res) $flag = 'success';

        return response()->json(array('flag'=> $flag), 200);
    }

    //案例分类删除
    public function categoryDel()
    {
        $delId = request('delId');

        $example = new Example();

        $num = $example->where('categoryId', $delId)->count();

        if($num > 0){
            return response()->json(array('flag'=> 'exist'), 200);
        }

        $exampleCategory = new ExampleCategory();

        $res = $exampleCategory->where('id', $delId)->delete();

        $flag = 'error';
        if($res) $flag = 'success';

        return response()->json(array('flag'=> $flag), 200);
    }

    //获取全部案列分类
    public function categoryAll()
    {
        $exampleCategory = new ExampleCategory();

        $res = $exampleCategory->pluck('name', 'id');

        return response()->json(array('data'=> $res), 200);
    }

    //案例添加页
    public function add()
    {
        $now = Carbon::now();
        $datePath = $now->year.'/'.$now->month.'/'.$now->day;

        if(session('addDatePath')) $datePath = session('addDatePath');

        $exampleCategory = new ExampleCategory();
        $categoryData = $exampleCategory->pluck('name', 'id');

        return view('admin.dashboard.example.add', compact('datePath', 'categoryData'));
    }

    //案例添加保存
    public function store()
    {
        $category = request('pCategory');
        $name = request('pName');
        $image = request('pImage');
        $content = request('pContent');

        $example = new Example();

        $userId = Auth::user()->userId;

        $res = $example->create([
            'categoryId' => $category,
            'name' => $name,
            'image' => $image,
            'content' => $content,
            'addUser' => $userId
        ]);

        if($res){
            session()->flash('store_res', '添加成功！');

            return redirect()->route('exampleAdd');
        }else{
            session()->flash('store_res', '添加失败！');

            return back();
        }
    }

    //案例列表页
    public function list()
    {
        return view('admin.dashboard.example.list');
    }

    //案例修改
    public function modify()
    {
        $modifyId = request('modifyId');

        $example = new Example();
        $data = $example->where('id', $modifyId)->first();
        session()->flash('exampleData', $data);

        $addDate = new Carbon($data->created_at);
        session()->flash('addDatePath', $addDate->year.'/'.$addDate->month.'/'.$addDate->day);

        return redirect()->route('exampleAdd');
    }

    //产品修改保存
    public function storeModify()
    {
        $modifyId = request('modifyId');
        $category = request('pCategory');
        $name = request('pName');
        $image = request('pImage');
        $content = request('pContent');

        $example = new Example();

        $res = $example->where('id', $modifyId)->update([
            'categoryId' => $category,
            'name' => $name,
            'image' => $image,
            'content' => $content
        ]);

        if($res){
            session()->flash('store_res', '修改成功！');

            return redirect()->route('exampleList');
        }else{
            session()->flash('store_res', '修改失败！');

            return back();
        }
    }

    //案例删除
    public function del()
    {
        $ids = request('ids');

        $res = DB::delete("delete from examples where id in (".$ids.")");

        if($res){
            $res = 'success';
        }else{
            $res = 'error';
        }

        return response()->json(array('flag'=> $res), 200);
    }
}
