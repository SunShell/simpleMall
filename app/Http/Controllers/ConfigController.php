<?php

namespace App\Http\Controllers;

use App\SetCommon;
use App\SetContact;
use Carbon\Carbon;

class ConfigController extends Controller
{
    //获取配置参数
    public function getWebsiteConfig($key)
    {
        $setCommon = new SetCommon();

        $res = $setCommon->where('key', $key)->value('value');

        if($key == 'site_logo'){
            if($res){
                $res = '/uploads/images/common/'.$res;
            }else{
                $res = '/images/logo-dark.png';
            }
        } else if($key == 'site_icon'){
            if($res){
                $res = '/uploads/images/common/'.$res;
            }else{
                $res = '/images/favicon.png';
            }
        } else if($key == 'site_qr') {
            if($res){
                $res = '/uploads/images/common/'.$res;
            }else{
                $res = '/images/qr.png';
            }
        }

        return $res;
    }

    //获取联系方式
    public function getWebsiteContact($key = '')
    {
        $setContact = new SetContact();

        $res = $setContact->first();

        if(!$res){
            if($key) return '';

            return null;
        }else{
            if($key) return $res->$key;

            return $res;
        }
    }

    //获取导航
    public function getWebsiteNav()
    {
        return array('index' => '网站首页','product' => '凯创产品','service' => '服务与支持','example' => '案例展示','about' => '关于我们','article' => '新闻中心','contact' => '联系我们');
    }

    //根据创建时间获取图片路径
    public function getImage($val,$tm,$type,$first=false)
    {
        $addDate = new Carbon($tm);

        $datePath = 'uploads/images/'.$type.'/'.$addDate->year.'/'.$addDate->month.'/'.$addDate->day.'/';

        $arr = explode(',', $val);
        $res = array();

        if($first) return asset($datePath.$arr[0]);

        foreach ($arr as $one) {
            array_push($res, asset($datePath.$one));
        }

        return $res;
    }
}
