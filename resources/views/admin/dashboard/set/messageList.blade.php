@extends('admin.layouts.master')

@section('cssContent')
    <link href="{{ asset('/css/shellPaginate.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="panel panel-headline">
        <div class="panel-heading">
            <h3 class="panel-title">留言管理</h3>
        </div>

        <input type="hidden" id="theToken" value="{{ csrf_token() }}">

        <div class="spOpContainer">
            <input type="text" class="form-control spOpIpt" id="queryContent" placeholder="联系人、联系方式或留言内容">&nbsp;&nbsp;
            <a class="btn btn-primary"><i class="fa fa-search"></i> 搜索</a>&nbsp;&nbsp;
            <a class="btn btn-danger"><i class="fa fa-times"></i> 删除</a>
        </div>

        <div class="panel-body no-padding" id="mlContainer"></div>
    </div>
@endsection

@section('jsContent')
    <script src="{{ asset('/js/shellPaginate.js') }}"></script>
    <script src="{{ asset('/js/set/messageList.js') }}"></script>
@endsection