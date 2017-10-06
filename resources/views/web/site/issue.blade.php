@extends('web.layouts.master')

@section('cssContent')
    <link rel="stylesheet" href="{{ asset('/css/service.css') }}">
@endsection

@section('content')
    <div class="mainContainer">
        <div class="mainNav">
            <input type="hidden" id="theToken" value="{{ csrf_token() }}">
            <input type="hidden" id="itemNum" value="{{ $itemNum }}">
            <ul>
                <li class="title">{{ $pageName }}</li>
                <li><a class="active" href="/service/issue">热门问题</a></li>
                <li><a href="/service/vendor">经销商查询</a></li>
            </ul>
        </div>

        <div class="mainContent">
            <div class="serviceContainer" id="containerDiv">
            </div>
        </div>

        <div class="mainClear"></div>
    </div>
@endsection

@section('jsContent')
    <script src="{{ asset('/js/site/issue.js') }}"></script>
@endsection
