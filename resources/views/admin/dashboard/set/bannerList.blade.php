@extends('admin.layouts.master')

@section('cssContent')
    <link href="{{ asset('/css/shellPaginate.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="panel panel-headline">
        <div class="panel-heading">
            <h3 class="panel-title">首页轮播图管理</h3>
        </div>

        <input type="hidden" id="thePath" value="{{ asset('uploads/images/banner') }}">
        <input type="hidden" id="theToken" value="{{ csrf_token() }}">

        <div class="spOpContainer">
            <a class="btn btn-success" ><i class="fa fa-plus"></i> 添加</a>
        </div>

        <div class="panel-body no-padding">
            <table class="table table-striped spListTable">
                <thead>
                <tr>
                    <th>轮播图</th>
                    <th>链接地址</th>
                    <th>添加人</th>
                    <th>添加时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                @foreach($setBannerData as $tmpOne)
                    <tr>
                        <td><img class="banner_list_image" src="{{ asset('uploads/images/banner/'.$tmpOne->image) }}"></td>
                        <td>{{ $tmpOne->href }}</td>
                        <td>{{ $userData[$tmpOne->addUser] or $tmpOne->addUser }}</td>
                        <td>{{ $tmpOne->created_at }}</td>
                        <td>
                            <a class="spListModify" title="修改" data-value="{{ $tmpOne->id }}"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                            <a class="spListDel" title="删除" data-value="{{ $tmpOne->id }}"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                @endforeach
                <tbody>
                </tbody>
        </div>
    </div>
@endsection

@section('jsContent')
    <script src="https://cdn.bootcss.com/jquery.form/4.2.1/jquery.form.min.js"></script>
    <script src="{{ asset('/js/set/bannerList.js') }}"></script>
@endsection
