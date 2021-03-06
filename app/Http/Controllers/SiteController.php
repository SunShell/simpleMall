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
use App\ServiceIssue;
use App\ServiceVendor;
use App\SetBanner;
use App\SetMessage;

class SiteController extends Controller
{
    public function index()
    {
        $pageName = '首页';
        $pageId = 'index';

        $setBanner = new SetBanner();
        $productCategory = new ProductCategory();
        $article = new Article();
        $articleCategory = new ArticleCategory();

        $bannerData = $setBanner->orderBy('created_at','desc')->offset(0)->limit(4)->get();
        $productData = $productCategory->where('indexShow', 1)->get();

        $twoCategory = $articleCategory->orderBy('id', 'asc')->offset(0)->limit(2)->get(['id', 'name']);
        $articleData = array();

        foreach ($twoCategory as $two) {
            $res = $article->where('categoryId', $two->id)->orderBy('publishTime', 'desc')->offset(0)->limit(6)->get();
            $articleData[$two->id] = array(
                'name' => $two->name,
                'data' => $res
            );
        }

        return view('web.site.index', compact('pageName', 'pageId', 'bannerData', 'productData', 'articleData'));
    }

    //留言保存
    public function messageStore()
    {
        $messageName = request('messageName');
        $messagePhone = request('messagePhone');
        $messageContent = request('messageContent');

        $setMessage = new SetMessage();

        $res = $setMessage->create([ 'name' => $messageName, 'phone' => $messagePhone, 'content' => $messageContent ]);

        $flag = 'error';
        if($res) $flag = 'success';

        return response()->json(array('flag'=> $flag), 200);
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
        $pageName = '凯创产品';
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
        $pageName = '凯创产品';
        $pageId = 'product';

        $product = new Product();
        $productCategory = new ProductCategory();

        $itemNum = $product->where('categoryId', $categoryId)->count();

        if($itemNum < 1){
            return redirect('/product');
        }

        $ids = $product->groupBy('categoryId')->pluck('categoryId');

        $categoryData = $productCategory->whereIn('id', $ids)->pluck('name', 'id');

        $pageSub = array([ 'route' => '/product/list/'.$categoryId, 'name' => $categoryData[$categoryId] ]);

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
        $pageName = '凯创产品';
        $pageId = 'product';

        $product = new Product();
        $productCategory = new ProductCategory();
        $productAttr = new ProductAttr();
        $productConfig = new ProductConfig();

        $num = $product->where('id', $productId)->count();

        if($num < 1){
            return redirect('/product');
        }

        $productData = $product->where('id', $productId)->first();
        $ids = $product->groupBy('categoryId')->pluck('categoryId');
        $categoryData = $productCategory->whereIn('id', $ids)->pluck('name','id');
        $categoryName = $productCategory->where('id', $productData->categoryId)->value('name');

        $pageSub = array([ 'route' => '/product/list/'.$productData->categoryId, 'name' => $categoryName ], [ 'name' => $productData->name ]);

        $attrData = $productAttr->where('productId', $productId)->get();

        $names = $productAttr->where('productId', $productId)->orderBy('id', 'asc')->pluck('name');
        $attrGroup = array();
        foreach ($names as $name) {
            if(!in_array($name, $attrGroup)) array_push($attrGroup, $name);
        }

        $configData = $productConfig->pluck('name', 'id');

        $configGroup = $productAttr->where('productId', $productId)->where('value', '<>', '-')->groupBy('configId')->pluck('configId');

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

        $itemNum = $example->where('categoryId', $categoryId)->count();

        if($itemNum < 1){
            return redirect('/example');
        }

        $ids = $example->groupBy('categoryId')->pluck('categoryId');

        $categoryData = $exampleCategory->whereIn('id', $ids)->pluck('name', 'id');

        $pageSub = array([ 'route' => '/example/list/'.$categoryId, 'name' => $categoryData[$categoryId] ]);

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

        $num = $example->where('id', $exampleId)->count();

        if($num < 1){
            return redirect('/example');
        }

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

        $itemNum = $article->where('categoryId', $categoryId)->count();

        if($itemNum < 1){
            return redirect('/article');
        }

        $categoryData = $articleCategory->pluck('name', 'id');

        $pageSub = array([ 'name' => $categoryData[$categoryId] ]);

        return view('web.site.articleList', compact('pageName', 'pageId', 'categoryId', 'categoryData', 'pageSub', 'itemNum'));
    }

    public function getArticleList()
    {
        $pageId = request('pageId');
        $categoryId = request('categoryId');

        $article = new Article();

        if($categoryId == 'all'){
            $res = $article->orderBy('publishTime', 'desc')->offset(($pageId-1)*5)->limit(5)->get();
        }else{
            $res = $article->where('categoryId', $categoryId)->orderBy('publishTime', 'desc')->offset(($pageId-1)*5)->limit(5)->get();
        }

        return response()->json(array('data'=> $res), 200);
    }

    public function articleDetail($articleId)
    {
        $pageName = '新闻中心';
        $pageId = 'article';

        $article = new Article();
        $articleCategory = new ArticleCategory();

        $num = $article->where('id', $articleId)->count();

        if($num < 1){
            return redirect('/article');
        }

        $articleData = $article->where('id', $articleId)->first();

        $categoryName = $articleCategory->where('id', $articleData->categoryId)->value('name');

        $pageSub = array([ 'route' => '/article/list/'.$articleData->categoryId, 'name' => $categoryName ]);

        return view('web.site.articleDetail', compact('pageName', 'pageId', 'pageSub', 'articleData'));
    }

    public function service()
    {
        $pageName = '服务与支持';
        $pageId = 'service';

        $serviceIssue = new ServiceIssue();

        $issueData = $serviceIssue->orderBy('reads', 'desc')->offset(0)->limit(8)->get();

        return view('web.site.service', compact('pageName', 'pageId', 'issueData'));
    }

    public function issue()
    {
        $pageName = '服务与支持';
        $pageId = 'service';

        $pageSub = array([ 'name' => '热门问题' ]);

        $serviceIssue = new ServiceIssue();

        $itemNum = $serviceIssue->count();

        return view('web.site.issue', compact('pageName', 'pageId', 'pageSub', 'itemNum'));
    }

    public function getIssues()
    {
        $pageId = request('pageId');

        $serviceIssue = new ServiceIssue();

        $res = $serviceIssue->orderBy('reads', 'desc')->offset(($pageId-1)*10)->limit(10)->get(['id','name']);

        return response()->json(array('data'=> $res), 200);
    }

    public function issueDetail($issueId)
    {
        $pageName = '服务与支持';
        $pageId = 'service';

        $pageSub = array([ 'name' => '热门问题' ]);

        $serviceIssue = new ServiceIssue();

        $issueData = $serviceIssue->where('id', $issueId)->first();

        if($issueData){
            $serviceIssue->where('id', $issueId)->update(['reads' => $issueData->reads+1 ]);
        }else{
            return redirect('/service/issue');
        }

        return view('web.site.issueDetail', compact('pageName', 'pageId', 'pageSub', 'issueData'));
    }

    public function vendor()
    {
        $pageName = '服务与支持';
        $pageId = 'service';

        $pageSub = array([ 'name' => '经销商查询' ]);

        return view('web.site.vendor', compact('pageName', 'pageId', 'pageSub'));
    }

    public function getVendor()
    {
        $vendorNumber = request('vendorNumber');
        $vendorName = request('vendorName');

        $serviceVendor = new ServiceVendor();

        $num = $serviceVendor->where('number', $vendorNumber)->where('name', $vendorName)->count();

        $flag = 'no';
        $res = '';

        if($num > 0){
            $flag = 'yes';
            $res = $serviceVendor->where('number', $vendorNumber)->where('name', $vendorName)->first();
        }

        return response()->json(array('flag' => $flag, 'data'=> $res), 200);
    }
}
