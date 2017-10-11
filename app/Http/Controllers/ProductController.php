<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\ProductCategory;
use App\ProductConfig;
use App\Product;
use App\ProductAttr;
use App\ProductCategoryConfig;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //分类列表
    public function categoryList()
    {
        return view('admin.dashboard.product.categoryList');
    }

    //分类添加
    public function categoryAdd()
    {
        $name = request('categoryName');
        $indexShow = request('categoryIndexShow');

        $productCategory = new ProductCategory();

        $num = $productCategory->where('name',$name)->count();

        if($num > 0){
            return response()->json(array('flag'=> 'exist'), 200);
        }else{
            $userId = Auth::user()->userId;

            if($indexShow == 1){
                $res = $productCategory->create(['name' => $name,
                                                 'addUser' => $userId,
                                                 'indexShow' => $indexShow,
                                                 'showName' => request('categoryShowName'),
                                                 'image' => request('categoryImage'),
                                                 'briefIntroduction' => request('categoryBriefIntroduction')
                ]);
            }else{
                $res = $productCategory->create(['name' => $name, 'addUser' => $userId]);
            }

            if($res){
                $res = 'success';
            }else{
                $res = 'error';
            }

            return response()->json(array('flag'=> $res), 200);
        }
    }

    //获取一条分类的信息
    public function categoryGet()
    {
        $id = request('categoryId');
        $productCategory = new ProductCategory();
        $data = $productCategory->where('id', $id)->first();

        if($data){
            return response()->json(array('flag'=> 'success', 'data'=> $data), 200);
        }else{
            return response()->json(array('flag'=> 'error'), 200);
        }
    }

    //分类修改
    public function categoryModify()
    {
        $id = request('categoryId');
        $name = request('categoryName');

        $productCategory = new ProductCategory();
        $num = $productCategory->where('id','<>', $id)->where('name', $name)->count();

        if($num > 0){
            return response()->json(array('flag'=> 'exist'), 200);
        }else{
            $res = $productCategory->where('id', $id)->update([
                'name' => $name,
                'indexShow' => request('categoryIndexShow'),
                'showName' => request('categoryShowName'),
                'image' => request('categoryImage'),
                'briefIntroduction' => request('categoryBriefIntroduction')
            ]);

            $flag = 'error';
            if($res) $flag = 'success';

            return response()->json(array('flag'=> $flag), 200);
        }
    }

    //分类删除
    public function categoryDel()
    {
        $id = request('delId');

        $product = new Product();

        $num = $product->where('categoryId', $id)->count();

        if($num > 0){
            return response()->json(array('flag'=> 'exist'), 200);
        }else{
            $productCategory = new ProductCategory();
            $res = $productCategory->destroy($id);

            if($res){
                $res = 'success';
            }else{
                $res = 'error';
            }

            return response()->json(array('flag'=> $res), 200);
        }
    }

    //获取全部分类
    public function categoryAll()
    {
        $productCategory = new ProductCategory();

        $res = $productCategory->pluck('name', 'id');

        return response()->json(array('data'=> $res), 200);
    }

    //参数列表页面
    public function configList()
    {
        $productConfig = new ProductConfig();
        $user = new User();

        $productConfigData = $productConfig->all();
        $userData = $user->pluck('name', 'userId');

        $productCategory = new ProductCategory();
        $categoryData = $productCategory->pluck('name', 'id');

        return view('admin.dashboard.product.configList', compact('productConfigData','userData', 'categoryData'));
    }

    //参数添加
    public function configAdd()
    {
        $name = request('configName');

        $productConfig = new ProductConfig();

        $num = $productConfig->where('name', $name)->count();

        if($num > 0){
            return response()->json(array('flag'=> 'exist'), 200);
        }else{
            $userId = Auth::user()->userId;

            $res = $productConfig->create(['name' => $name, 'addUser' => $userId]);

            if($res){
                return response()->json(array('flag'=> 'success'), 200);
            }else{
                return response()->json(array('flag'=> 'error'), 200);
            }
        }
    }

    //参数修改
    public function configModify()
    {
        $id = request('configId');
        $name = request('configName');

        $productConfig = new ProductConfig();

        $num = $productConfig->where('id', '<>', $id)->where('name', $name)->count();

        if($num > 0){
            return response()->json(array('flag'=> 'exist'), 200);
        }else {
            $res = $productConfig->where('id', $id)->update(['name' => $name]);

            $flag = 'error';
            if($res) $flag = 'success';

            return response()->json(array('flag'=> $flag), 200);
        }
    }

    //参数删除
    public function configDel()
    {
        $id = request('configId');

        $productConfig = new ProductConfig();
        $productAttr = new ProductAttr();
        $productCategoryConfig = new ProductCategoryConfig();

        $res = $productConfig->destroy($id);
        $flag = 'error';

        if($res){
            $productAttr->where('configId', $id)->delete();
            $productCategoryConfig->where('configId', $id)->delete();
            $flag = 'success';
        }

        return response()->json(array('flag'=> $flag), 200);
    }

    //参数获取
    public function getCategoryConfig()
    {
        $categoryId = request('categoryId');

        $productCategoryConfig = new ProductCategoryConfig();

        $res = $productCategoryConfig->where('categoryId', $categoryId)->pluck('configId');

        return response()->json(array('data'=> $res), 200);
    }

    //参数配置
    public function setCategoryConfig()
    {
        $categoryId = request('categoryId');
        $configIds = request('configIds');

        $arr = explode(',', $configIds);

        $productCategoryConfig = new ProductCategoryConfig();

        $productCategoryConfig->where('categoryId', $categoryId)->delete();

        foreach ($arr as $one) {
            $productCategoryConfig->create(['categoryId' => $categoryId, 'configId' => $one]);
        }

        return response()->json(array('flag'=> 'success'), 200);
    }

    //产品添加页
    public function add()
    {
        $now = Carbon::now();
        $datePath = $now->year.'/'.$now->month.'/'.$now->day;

        if(session('addDatePath')) $datePath = session('addDatePath');

        $productCategory = new ProductCategory();
        $categoryData = $productCategory->pluck('name', 'id');

        $productConfig = new ProductConfig();
        $configData = $productConfig->pluck('name', 'id');

        return view('admin.dashboard.product.add', compact('datePath', 'categoryData', 'configData'));
    }

    //产品保存
    public function store()
    {
        $category = request('pCategory');
        $name = request('pTitle');
        $images = request('pImages');
        $photos = request('pPhotos');
        $introduce = request('pIntroduce');
        $attr = request('pAttr');

        $product = new Product();

        $userId = Auth::user()->userId;

        $res = $product->create([
            'categoryId' => $category,
            'name' => $name,
            'images' => $images,
            'photos' => $photos,
            'introduce' => $introduce,
            'addUser' => $userId
        ]);

        if($res){
            $id = $res->id;
            $arr = explode(chr(1),$attr);
            $productAttr = new ProductAttr();

            foreach ($arr as $one){
                $tmpArr = explode(chr(2), $one);

                if(count($tmpArr) != 2) continue;

                $tmpName = $tmpArr[0];
                $tmpBrr = explode(chr(3), $tmpArr[1]);

                foreach ($tmpBrr as $tmpOne){
                    $tmpCrr = explode(chr(4), $tmpOne);

                    if(count($tmpCrr) != 2) continue;

                    $productAttr->create([
                        'productId' => $id,
                        'name' => $tmpName,
                        'configId' => $tmpCrr[0],
                        'value' => $tmpCrr[1]
                    ]);
                }
            }

            session()->flash('store_res', '添加成功！');

            return redirect()->route('productAdd');
        }else{
            session()->flash('store_res', '添加失败！');

            return back();
        }
    }

    //产品列表
    public function productList()
    {
        return view('admin.dashboard.product.list');
    }

    //产品删除
    public function del()
    {
        $ids = request('ids');

        $res = DB::delete("delete from products where id in (".$ids.")");

        if($res){
            $res = 'success';

            DB::delete("delete from product_attrs where productId in (".$ids.")");
        }else{
            $res = 'error';
        }

        return response()->json(array('flag'=> $res), 200);
    }

    //产品修改
    public function modify()
    {
        $modifyId = request('modifyId');

        $product = new Product();
        $data = $product->where('id', $modifyId)->first();
        session()->flash('productData', $data);

        $addDate = new Carbon($data->created_at);
        session()->flash('addDatePath', $addDate->year.'/'.$addDate->month.'/'.$addDate->day);

        $productCategoryConfig = new ProductCategoryConfig();
        $config = $productCategoryConfig->where('categoryId', $data->categoryId)->pluck('configId');
        session()->flash('productConfigData', $config);

        $productAttr = new ProductAttr();
        $subData = $productAttr->where('productId', $modifyId)->get();
        session()->flash('productAttrData', $subData);

        $names = $productAttr->where('productId', $modifyId)->orderBy('id', 'asc')->pluck('name');
        $groupData = array();
        foreach ($names as $name) {
            if(!in_array($name, $groupData)) array_push($groupData, $name);
        }
        session()->flash('productAttrGroup', $groupData);

        return redirect()->route('productAdd');
    }

    //产品修改保存
    public function storeModify()
    {
        $modifyId = request('modifyId');
        $category = request('pCategory');
        $name = request('pTitle');
        $images = request('pImages');
        $photos = request('pPhotos');
        $introduce = request('pIntroduce');
        $attr = request('pAttr');

        $product = new Product();

        $res = $product->where('id', $modifyId)->update([
            'categoryId' => $category,
            'name' => $name,
            'images' => $images,
            'photos' => $photos,
            'introduce' => $introduce
        ]);

        if($res){
            $arr = explode(chr(1), $attr);

            $productAttr = new ProductAttr();

            $productAttr->where('productId', $modifyId)->delete();

            foreach ($arr as $one){
                $tmpArr = explode(chr(2), $one);

                if(count($tmpArr) != 2) continue;

                $tmpName = $tmpArr[0];
                $tmpBrr = explode(chr(3), $tmpArr[1]);

                foreach ($tmpBrr as $tmpOne){
                    $tmpCrr = explode(chr(4), $tmpOne);

                    if(count($tmpCrr) != 2) continue;

                    $productAttr->create([
                        'productId' => $modifyId,
                        'name' => $tmpName,
                        'configId' => $tmpCrr[0],
                        'value' => $tmpCrr[1]
                    ]);
                }
            }

            session()->flash('store_res', '修改成功！');

            return redirect()->route('productList');
        }else{
            session()->flash('store_res', '修改失败！');

            return back();
        }
    }
}
