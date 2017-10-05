@extends('web.layouts.master')

@section('cssContent')
    <link rel="stylesheet" href="{{ asset('/css/article.css') }}">
@endsection

@section('content')
    <div class="mainContainer">
        <div class="mainNav">
            <input type="hidden" id="theToken" value="{{ csrf_token() }}">
            <input type="hidden" id="itemNum" value="{{ $itemNum }}">
            <input type="hidden" id="categoryId" value="{{ $categoryId }}">
            <input type="hidden" id="imagePath" value="{{ asset('/uploads/images/article') }}">
            <ul>
                <li class="title">{{ $pageName }}</li>
                @foreach($categoryData as $key => $val)
                    @if($categoryId == $key)
                        <li><a class="active" href="/article/list/{{ $key }}">{{ $val }}</a></li>
                    @else
                        <li><a href="/article/list/{{ $key }}">{{ $val }}</a></li>
                    @endif
                @endforeach
            </ul>
        </div>

        <div class="mainContent" id="containerDiv">
        </div>

        <div class="mainClear"></div>
    </div>
@endsection

@section('jsContent')
    <script src="{{ asset('/js/site/articleList.js') }}"></script>
@endsection
