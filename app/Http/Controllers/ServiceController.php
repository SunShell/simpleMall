<?php

namespace App\Http\Controllers;

use App\ServiceIssue;
use App\ServiceVendor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //问题列表页
    public function issueList()
    {
        return view('admin.dashboard.service.issueList');
    }

    //问题添加
    public function issueAdd()
    {
        $issueName = request('issueName');
        $issueContent = request('issueContent');

        $serviceIssue = new ServiceIssue();

        $num = $serviceIssue->where('name', $issueName)->count();

        if($num > 0){
            return response()->json(array('flag'=> 'exist'), 200);
        }

        $userId = Auth::user()->userId;

        $res = $serviceIssue->create([
            'name' => $issueName,
            'content' => $issueContent,
            'reads' => 0,
            'addUser' => $userId
        ]);

        $flag = 'error';
        if($res) $flag = 'success';

        return response()->json(array('flag'=> $flag), 200);
    }

    //获取问题信息
    public function issueGet()
    {
        $issueId = request('issueId');

        $serviceIssue = new ServiceIssue();
        $data = $serviceIssue->where('id', $issueId)->first();

        if($data){
            return response()->json(array('flag'=> 'success', 'data'=> $data), 200);
        }else{
            return response()->json(array('flag'=> 'error'), 200);
        }
    }

    //问题修改
    public function issueModify()
    {
        $issueId = request('issueId');
        $issueName = request('issueName');
        $issueContent = request('issueContent');

        $serviceIssue = new ServiceIssue();
        $num = $serviceIssue->where('id','<>', $issueId)->where('name', $issueName)->count();

        if($num > 0){
            return response()->json(array('flag'=> 'exist'), 200);
        }

        $res = $serviceIssue->where('id', $issueId)->update([
            'name' => $issueName,
            'content' => $issueContent
        ]);

        $flag = 'error';
        if($res) $flag = 'success';

        return response()->json(array('flag'=> $flag), 200);
    }

    //问题删除
    public function issueDel()
    {
        $delId = request('delId');

        $res = DB::delete("delete from service_issues where id in (".$delId.")");

        $flag = 'error';
        if($res) $flag = 'success';

        return response()->json(array('flag'=> $flag), 200);
    }

    //经销商列表页
    public function vendorList()
    {
        return view('admin.dashboard.service.vendorList');
    }

    //经销商添加
    public function vendorAdd()
    {
        $vendorNumber = request('vendorNumber');
        $vendorName = request('vendorName');
        $vendorImage = request('vendorImage');

        $serviceVendor = new ServiceVendor();

        $num = $serviceVendor->where('name', $vendorName)->where('number', $vendorNumber)->count();

        if($num > 0){
            return response()->json(array('flag'=> 'exist'), 200);
        }

        $userId = Auth::user()->userId;

        $res = $serviceVendor->create([
            'name' => $vendorName,
            'number' => $vendorNumber,
            'image' => $vendorImage,
            'addUser' => $userId
        ]);

        $flag = 'error';
        if($res) $flag = 'success';

        return response()->json(array('flag'=> $flag), 200);
    }

    //获取经销商信息
    public function vendorGet()
    {
        $vendorId = request('vendorId');

        $serviceVendor = new ServiceVendor();
        $data = $serviceVendor->where('id', $vendorId)->first();

        if($data){
            return response()->json(array('flag'=> 'success', 'data'=> $data), 200);
        }else{
            return response()->json(array('flag'=> 'error'), 200);
        }
    }

    //修改经销商
    public function vendorModify()
    {
        $vendorId = request('vendorId');
        $vendorNumber = request('vendorNumber');
        $vendorName = request('vendorName');
        $vendorImage = request('vendorImage');

        $serviceVendor = new ServiceVendor();
        $num = $serviceVendor->where('id','<>', $vendorId)->where('number', $vendorNumber)->where('name', $vendorName)->count();

        if($num > 0){
            return response()->json(array('flag'=> 'exist'), 200);
        }

        $res = $serviceVendor->where('id', $vendorId)->update([
            'name' => $vendorName,
            'number' => $vendorNumber,
            'image' => $vendorImage
        ]);

        $flag = 'error';
        if($res) $flag = 'success';

        return response()->json(array('flag'=> $flag), 200);
    }

    //经销商删除
    public function vendorDel()
    {
        $delId = request('delId');

        $res = DB::delete("delete from service_vendors where id in (".$delId.")");

        $flag = 'error';
        if($res) $flag = 'success';

        return response()->json(array('flag'=> $flag), 200);
    }
}
