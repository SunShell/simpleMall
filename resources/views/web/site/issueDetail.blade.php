@extends('web.layouts.master')

@section('cssContent')
    <link rel="stylesheet" href="{{ asset('/css/service.css') }}">
@endsection

@section('content')
    <div class="mainContainer">
        <div class="mainNav">
            <ul>
                <li class="title">{{ $pageName }}</li>
                <li><a class="active" href="/service/issue">热门问题</a></li>
                <li><a href="/service/vendor">经销商查询</a></li>
            </ul>
        </div>

        <div class="mainContent">
            <div class="serviceContainer">
                <h3>{{ $issueData->name }}</h3>
                <div class="issueContainer">{!! $issueData->content !!}</div>
            </div>
        </div>

        <div class="mainClear"></div>
    </div>
@endsection
