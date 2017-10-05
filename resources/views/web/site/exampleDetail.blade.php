<?php
use App\Http\Controllers\ConfigController;

$cc = new ConfigController();
?>

@extends('web.layouts.master')

@section('cssContent')
    <link rel="stylesheet" href="{{ asset('/css/product.css') }}">
@endsection

@section('content')
    <div class="mainContainer">
        <div class="mainNav">
            <ul>
                <li class="title">{{ $pageName }}</li>
                @foreach($categoryData as $key => $val)
                    @if($key == $exampleData->categoryId)
                        <li><a class="active" href="/example/list/{{ $key }}">{{ $val }}</a></li>
                    @else
                        <li><a href="/example/list/{{ $key }}">{{ $val }}</a></li>
                    @endif
                @endforeach
            </ul>
        </div>

        <div class="mainContent">
            <div class="detailTitle">{{ $exampleData->name }}</div>

            <div class="detailImg">
                <div class="leftImgBig">
                    <img class="imageBig" src="{{ $cc->getImage($exampleData->image,$exampleData->created_at,'example',true) }}">
                </div>

                <div class="rightImg">
                    <div class="upDown up"></i></div>
                    <div class="imageAll">
                        <?php $images = $cc->getImage($exampleData->image,$exampleData->created_at,'example'); ?>
                        <div class="imageMove">
                            @foreach($images as $image)
                                <img class="imageSmallTwo imageMap" src="{{ $image }}">
                            @endforeach
                        </div>
                    </div>
                    <div class="upDown down"></div>
                </div>

                <div class="mainClear"></div>
            </div>

            <div class="detailTit">展会详情</div>

            <div class="detailContent">{!! $exampleData->content !!}</div>
        </div>

        <div class="mainClear"></div>
    </div>
@endsection

@section('jsContent')
    <script src="{{ asset('/js/site/exampleDetail.js') }}"></script>
@endsection
