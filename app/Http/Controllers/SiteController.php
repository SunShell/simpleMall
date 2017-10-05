<?php

namespace App\Http\Controllers;

use App\SetAbout;
use App\ProductCategory;
use App\Product;
use App\ProductAttr;
use App\ProductConfig;
use App\ProductCategoryConfig;

class SiteController extends Controller
{
    public function index()
    {
        $pageName = '首页';
        $pageId = 'index';

        return view('web.site.index', compact('pageName', 'pageId'));
    }

    public function about()
    {
        $pageName = '关于我们';
        $pageId = 'about';

        $setAbout = new SetAbout();
        $aboutData = $setAbout->first();

        return view('web.site.about', compact('pageName', 'pageId', 'aboutData'));
    }

    public function culture()
    {
        $pageName = '关于我们';
        $pageId = 'about';

        return view('web.site.culture', compact('pageName', 'pageId'));
    }

    public function contact()
    {
        $pageName = '联系我们';
        $pageId = 'contact';

        return view('web.site.contact', compact('pageName', 'pageId'));
    }

    public function product()
    {
        $pageName = '大上产品';
        $pageId = 'product';

        $product = new Product();
        $productCategory = new ProductCategory();

        $productData = array();
        $categoryData = $productCategory->pluck('name', 'id');

        $arr = $product->groupBy('categoryId')->pluck('categoryId');

        foreach ($arr as $item) {
            $res = $product->where('categoryId', $item)->offset(0)->limit(4)->get(['id','name','images','created_at']);
            $productData[$item] = $res;
        }

        return view('web.site.product', compact('pageName', 'pageId', 'categoryData', 'productData'));
    }

    //分类列表页
    public function productList($categoryId)
    {
        $pageName = '大上产品';
        $pageId = 'product';

        $productCategory = new ProductCategory();
        $categoryData = $productCategory->pluck('name', 'id');

        $pageSub = array([ 'route' => '/product/list/'.$categoryId, 'name' => $categoryData[$categoryId] ]);

        $product = new Product();

        $itemNum = $product->where('categoryId', $categoryId)->count();

        return view('web.site.productList', compact('pageName', 'pageId', 'categoryId', 'categoryData', 'pageSub', 'itemNum'));
    }

    //获取分页数据
    public function getList()
    {
        $pageId = request('pageId');
        $categoryId = request('categoryId');

        $product = new Product();
        $res = $product->where('categoryId', $categoryId)->offset(($pageId-1)*9)->limit(9)->get();

        return response()->json(array('data'=> $res), 200);
    }

    //产品详情
    public function productDetail($productId)
    {
        $pageName = '大上产品';
        $pageId = 'product';

        $product = new Product();
        $productCategory = new ProductCategory();
        $productAttr = new ProductAttr();
        $productConfig = new ProductConfig();
        $productCategoryConfig = new ProductCategoryConfig();

        $productData = $product->where('id', $productId)->first();
        $categoryData = $productCategory->pluck('name','id');
        $categoryName = $productCategory->where('id', $productData->categoryId)->value('name');

        $pageSub = array([ 'route' => '/product/list/'.$productData->categoryId, 'name' => $categoryName ], [ 'name' => $productData->name ]);

        $attrData = $productAttr->where('productId', $productId)->get();

        $attrGroup = $productAttr->where('productId', $productId)->groupBy('name')->pluck('name');

        $configData = $productConfig->pluck('name', 'id');

        $configGroup = $productCategoryConfig->where('categoryId', $productData->categoryId)->pluck('configId');

        return view('web.site.productDetail', compact('pageName', 'pageId', 'pageSub', 'productData', 'categoryData', 'attrData', 'attrGroup', 'configData', 'configGroup'));
    }
}
