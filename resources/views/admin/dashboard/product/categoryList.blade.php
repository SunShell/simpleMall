@extends('admin.layouts.master')

@section('cssContent')
    <link href="{{ asset('/css/shellPaginate.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="panel panel-headline">
        <div class="panel-heading">
            <h3 class="panel-title">产品分类管理</h3>
        </div>

        <input type="hidden" id="theSrc" value="{{ asset('uploads/images/product') }}">
        <input type="hidden" id="theToken" value="{{ csrf_token() }}">

        <div class="spOpContainer">
            <input type="text" class="form-control spOpIpt" id="queryCN" placeholder="请输入分类名称">&nbsp;
            <a class="btn btn-primary"><i class="fa fa-search"></i> 搜索</a>&nbsp;
            <a class="btn btn-success"><i class="fa fa-plus"></i> 添加</a>
        </div>

        <div class="panel-body no-padding" id="clContainer"></div>
    </div>
@endsection

@section('jsContent')
    <script src="https://cdn.bootcss.com/jquery.form/4.2.1/jquery.form.min.js"></script>
    <script src="{{ asset('/js/shellPaginate.js') }}"></script>
    <script src="{{ asset('/js/product/categoryList.js') }}"></script>
@endsection