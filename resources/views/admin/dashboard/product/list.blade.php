@extends('admin.layouts.master')

@section('cssContent')
    <link href="{{ asset('/css/shellPaginate.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="panel panel-headline">
        <div class="panel-heading">
            <h3 class="panel-title">产品列表</h3>
        </div>

        <input type="hidden" id="theSrc" value="{{ asset('uploads/images/product') }}">
        <input type="hidden" id="theToken" value="{{ csrf_token() }}">
        <input type="hidden" id="storeRes" value="{{ session('store_res') }}">

        <form id="modifyForm" method="post" action="/admin/product/modify" style="display: none;">
            {{ csrf_field() }}
            <input type="hidden" id="modifyId" name="modifyId">
        </form>

        <div class="spOpContainer">
            <label for="queryCategory">产品分类：</label>
            <select class="form-control spOpIpt" id="queryCategory"></select>&nbsp;&nbsp;

            <label for="queryName">产品名称：</label>
            <input type="text" class="form-control spOpIpt" id="queryName" placeholder="产品名称">&nbsp;&nbsp;

            <a class="btn btn-primary"><i class="fa fa-search"></i> 搜索</a>&nbsp;&nbsp;
            <a class="btn btn-success" href="/admin/product/add"><i class="fa fa-plus"></i> 添加</a>&nbsp;&nbsp;
            <a class="btn btn-danger"><i class="fa fa-times"></i> 删除</a>
        </div>

        <div class="panel-body no-padding" id="plContainer"></div>
    </div>
@endsection

@section('jsContent')
    <script src="https://cdn.bootcss.com/jquery.form/4.2.1/jquery.form.min.js"></script>
    <script src="{{ asset('/js/shellPaginate.js') }}"></script>
    <script src="{{ asset('/js/product/list.js') }}"></script>
@endsection