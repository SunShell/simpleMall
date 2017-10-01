<?php

namespace App\Http\Controllers;

use App\SetCommon;

class ConfigController extends Controller
{
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
        }

        return $res;
    }
}
