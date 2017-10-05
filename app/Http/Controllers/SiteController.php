<?php

namespace App\Http\Controllers;

use App\SetAbout;
use App\ProductCategory;
use App\Product;
use App\ProductAttr;
use App\ProductConfig;
use App\ProductCategoryConfig;
use App\Example;
use App\ExampleCategory;
use App\Article;
use App\ArticleCategory;

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

        $product = new Product();
        $productCategory = new ProductCategory();

        $ids = $product->groupBy('categoryId')->pluck('categoryId');

        $categoryData = $productCategory->whereIn('id', $ids)->pluck('name', 'id');

        $pageSub = array([ 'route' => '/product/list/'.$categoryId, 'name' => $categoryData[$categoryId] ]);

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
        $ids = $product->groupBy('categoryId')->pluck('categoryId');
        $categoryData = $productCategory->whereIn('id', $ids)->pluck('name','id');
        $categoryName = $productCategory->where('id', $productData->categoryId)->value('name');

        $pageSub = array([ 'route' => '/product/list/'.$productData->categoryId, 'name' => $categoryName ], [ 'name' => $productData->name ]);

        $attrData = $productAttr->where('productId', $productId)->get();

        $attrGroup = $productAttr->where('productId', $productId)->groupBy('name')->pluck('name');

        $configData = $productConfig->pluck('name', 'id');

        $configGroup = $productCategoryConfig->where('categoryId', $productData->categoryId)->pluck('configId');

        return view('web.site.productDetail', compact('pageName', 'pageId', 'pageSub', 'productData', 'categoryData', 'attrData', 'attrGroup', 'configData', 'configGroup'));
    }

    public function example()
    {
        $pageName = '案例展示';
        $pageId = 'example';

        $example = new Example();
        $exampleCategory = new ExampleCategory();

        $exampleData = array();
        $categoryData = $exampleCategory->pluck('name', 'id');

        $arr = $example->groupBy('categoryId')->pluck('categoryId');

        foreach ($arr as $item) {
            $res = $example->where('categoryId', $item)->offset(0)->limit(4)->get(['id','name','image','created_at']);
            $exampleData[$item] = $res;
        }

        return view('web.site.example', compact('pageName', 'pageId', 'categoryData', 'exampleData'));
    }

    public function exampleList($categoryId)
    {
        $pageName = '案例展示';
        $pageId = 'example';

        $example = new Example();
        $exampleCategory = new ExampleCategory();

        $ids = $example->groupBy('categoryId')->pluck('categoryId');

        $categoryData = $exampleCategory->whereIn('id', $ids)->pluck('name', 'id');

        $pageSub = array([ 'route' => '/example/list/'.$categoryId, 'name' => $categoryData[$categoryId] ]);

        $itemNum = $example->where('categoryId', $categoryId)->count();

        return view('web.site.exampleList', compact('pageName', 'pageId', 'categoryId', 'categoryData', 'pageSub', 'itemNum'));
    }

    //获取分页数据
    public function getExampleList()
    {
        $pageId = request('pageId');
        $categoryId = request('categoryId');

        $example = new Example();
        $res = $example->where('categoryId', $categoryId)->offset(($pageId-1)*9)->limit(9)->get();

        return response()->json(array('data'=> $res), 200);
    }

    public function exampleDetail($exampleId)
    {
        $pageName = '案例展示';
        $pageId = 'example';

        $example = new Example();
        $exampleCategory = new ExampleCategory();

        $exampleData = $example->where('id', $exampleId)->first();
        $ids = $example->groupBy('categoryId')->pluck('categoryId');
        $categoryData = $exampleCategory->whereIn('id', $ids)->pluck('name','id');
        $categoryName = $exampleCategory->where('id', $exampleData->categoryId)->value('name');

        $pageSub = array([ 'route' => '/example/list/'.$exampleData->categoryId, 'name' => $categoryName ], [ 'name' => $exampleData->name ]);

        return view('web.site.exampleDetail', compact('pageName', 'pageId', 'pageSub', 'exampleData', 'categoryData'));
    }

    public function article()
    {
        $pageName = '新闻中心';
        $pageId = 'article';
        $categoryId = 'all';

        $article = new Article();
        $articleCategory = new ArticleCategory();

        $categoryData = $articleCategory->pluck('name', 'id');

        $itemNum = $article->count();

        return view('web.site.articleList', compact('pageName', 'pageId', 'categoryId', 'categoryData', 'itemNum'));
    }

    public function articleList($categoryId)
    {
        $pageName = '新闻中心';
        $pageId = 'article';

        $article = new Article();
        $articleCategory = new ArticleCategory();

        $categoryData = $articleCategory->pluck('name', 'id');

        $pageSub = array([ 'name' => $categoryData[$categoryId] ]);

        $itemNum = $article->where('categoryId', $categoryId)->count();

        return view('web.site.articleList', compact('pageName', 'pageId', 'categoryId', 'categoryData', 'pageSub', 'itemNum'));
    }

    public function getArticleList()
    {
        $pageId = request('pageId');
        $categoryId = request('categoryId');

        $article = new Article();

        if($categoryId == 'all'){
            $res = $article->orderBy('created_at', 'desc')->offset(($pageId-1)*5)->limit(5)->get();
        }else{
            $res = $article->where('categoryId', $categoryId)->orderBy('created_at', 'desc')->offset(($pageId-1)*5)->limit(5)->get();
        }

        return response()->json(array('data'=> $res), 200);
    }

    public function articleDetail($articleId)
    {
        $pageName = '新闻中心';
        $pageId = 'article';

        $article = new Article();
        $articleCategory = new ArticleCategory();

        $articleData = $article->where('id', $articleId)->first();

        $categoryName = $articleCategory->where('id', $articleData->categoryId)->value('name');

        $pageSub = array([ 'route' => '/article/list/'.$articleData->categoryId, 'name' => $categoryName ]);

        return view('web.site.articleDetail', compact('pageName', 'pageId', 'pageSub', 'articleData'));
    }
}
