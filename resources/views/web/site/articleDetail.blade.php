@extends('web.layouts.master')

@section('cssContent')
    <link rel="stylesheet" href="{{ asset('/css/article.css') }}">
@endsection

@section('content')
    <div class="mainContainer">
        <div class="articleDetail">
            <h2>{{ $articleData->name }}</h2>
            <h3>发布时间：{{ $articleData->publishTime }}</h3>
            <div class="content">{!! $articleData->content !!}</div>
        </div>
    </div>
@endsection