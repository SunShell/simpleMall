<?php

namespace App\Http\Controllers;

use App\User;
use App\SetBanner;
use App\SetCommon;
use App\SetAbout;
use App\SetContact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //首页轮播图设置页
    public function banner()
    {
        $setBanner = new SetBanner();
        $user = new User();

        $setBannerData = $setBanner->all();
        $userData = $user->pluck('name', 'userId');

        return view('admin.dashboard.set.bannerList', compact('setBannerData','userData'));
    }

    //添加轮播图
    public function bannerAdd()
    {
        $bannerHref = request('bannerHref');
        $bannerImage = request('bannerImage');

        $setBanner = new SetBanner();

        $num = $setBanner->count();

        if($num >= 3){
            return response()->json(array('flag'=> 'enough'), 200);
        }

        $userId = Auth::user()->userId;

        $res = $setBanner->create([ 'image' => $bannerImage, 'href' => $bannerHref, 'addUser' => $userId ]);

        if($res){
            return response()->json(array('flag'=> 'success'), 200);
        }else{
            return response()->json(array('flag'=> 'error'), 200);
        }
    }

    //获取轮播图详情
    public function bannerGet()
    {
        $id = request('bannerId');
        $setBanner = new SetBanner();
        $data = $setBanner->where('id', $id)->first();

        if($data){
            return response()->json(array('flag'=> 'success', 'data'=> $data), 200);
        }else{
            return response()->json(array('flag'=> 'error'), 200);
        }
    }

    //轮播图修改
    public function bannerModify()
    {
        $bannerId = request('bannerId');
        $bannerHref = request('bannerHref');
        $bannerImage = request('bannerImage');

        $setBanner = new SetBanner();

        $res = $setBanner->where('id', $bannerId)->update([ 'image' => $bannerImage, 'href' => $bannerHref ]);

        if($res){
            return response()->json(array('flag'=> 'success'), 200);
        }else{
            return response()->json(array('flag'=> 'error'), 200);
        }
    }

    //轮播图删除
    public function bannerDel()
    {
        $bannerId = request('bannerId');

        $setBanner = new SetBanner();

        $num = $setBanner->count();

        if($num <= 1){
            return response()->json(array('flag'=> 'no'), 200);
        }

        $res = $setBanner->where('id', $bannerId)->delete();

        if($res){
            return response()->json(array('flag'=> 'success'), 200);
        }else{
            return response()->json(array('flag'=> 'error'), 200);
        }
    }

    //通用设置页面
    public function common()
    {
        $setCommon = new SetCommon();

        $setCommonData = $setCommon->pluck('value', 'key');

        return view('admin.dashboard.set.commonList', compact('setCommonData'));
    }

    //通用设置保存
    public function commonStore()
    {
        $setCommon = new SetCommon();

        $setCommon->where('id', '>', 0)->delete();

        $pSiteName = request('pSiteName');
        $pSiteKeywords = request('pSiteKeywords');
        $pSiteIntroduce = request('pSiteIntroduce');
        $pSiteBottom = request('pSiteBottom');
        $pSiteLogo = request('pSiteLogo');
        $pSiteIcon = request('pSiteIcon');
        $pSiteQr = request('pSiteQr');

        $res = $setCommon->insert([
            [ 'key' => 'site_name', 'value' => $pSiteName ],
            [ 'key' => 'site_keywords', 'value' => $pSiteKeywords ],
            [ 'key' => 'site_introduce', 'value' => $pSiteIntroduce ],
            [ 'key' => 'site_bottom', 'value' => $pSiteBottom ],
            [ 'key' => 'site_logo', 'value' => $pSiteLogo ],
            [ 'key' => 'site_icon', 'value' => $pSiteIcon ],
            [ 'key' => 'site_qr', 'value' => $pSiteQr ]
        ]);

        if($res){
            session()->flash('store_res', '保存成功！');
        }else{
            session()->flash('store_res', '保存失败！');
        }

        return redirect('/admin/set/common');
    }

    //关于我们页面
    public function about()
    {
        $setAbout = new SetAbout();

        $setAboutData = $setAbout->first();

        return view('admin.dashboard.set.aboutList', compact('setAboutData'));
    }

    //关于我们保存
    public function aboutStore()
    {
        $pImage = request('pImage');
        $pContent = request('pContent');

        $setAbout = new SetAbout();

        $rel = $setAbout->first();

        if($rel && $rel->id) {
            $res = $setAbout->where('id', $rel->id)->update([ 'image' => $pImage, 'content' => $pContent ]);
        }else{
            $userId = Auth::user()->userId;

            $res = $setAbout->create([ 'image' => $pImage, 'content' => $pContent, 'addUser' => $userId ]);
        }

        if($res){
            session()->flash('store_res', '保存成功！');
        }else{
            session()->flash('store_res', '保存失败！');
        }

        return redirect('/admin/set/about');
    }

    //联系方式设置
    public function contact()
    {
        $setContact = new SetContact();

        $setContactData = $setContact->first();

        return view('admin.dashboard.set.contactList', compact('setContactData'));
    }

    //联系方式保存
    public function contactStore()
    {
        $pPhone = request('pPhone');
        $pFax = request('pFax');
        $pEmail = request('pEmail');
        $pAddress = request('pAddress');

        $setContact = new SetContact();

        $rel = $setContact->first();

        if($rel && $rel->id){
            $res = $setContact->where('id', $rel->id)->update([ 'phone' => $pPhone, 'fax' => $pFax, 'email' => $pEmail, 'address' => $pAddress ]);
        }else{
            $userId = Auth::user()->userId;

            $res = $setContact->create([ 'phone' => $pPhone, 'fax' => $pFax, 'email' => $pEmail, 'address' => $pAddress, 'addUser' => $userId ]);
        }

        if($res){
            session()->flash('store_res', '保存成功！');
        }else{
            session()->flash('store_res', '保存失败！');
        }

        return redirect('/admin/set/contact');
    }

    //留言列表页
    public function message()
    {
        return view('admin.dashboard.set.messageList');
    }

    //留言删除
    public function messageDel()
    {
        $delId = request('delId');

        $res = DB::delete("delete from set_messages where id in (".$delId.")");

        if($res){
            return response()->json(array('flag'=> 'success'), 200);
        }else{
            return response()->json(array('flag'=> 'error'), 200);
        }
    }
}
