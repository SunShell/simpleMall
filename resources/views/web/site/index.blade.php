<?php
use App\Http\Controllers\ConfigController;

$cc = new ConfigController();
?>

@extends('web.layouts.master')

@section('cssContent')
    <link rel="stylesheet" href="{{ asset('/css/index.css') }}">
@endsection

@section('content')
    <!--BANNER部分-->
    <div class="indexBanner" id="indexBanner">
        <ul class="mainBanner">
            <?php $i=1; ?>
            @foreach($bannerData as $one)
                @if($i == 1)
                        <li hrefData="{{ $one->href }}" style="background-image: url({{ asset('/uploads/images/banner/'.$one->image) }}); z-index: 100;" id="mainBanner{{ $i }}"></li>
                    @else
                        <li hrefData="{{ $one->href }}" style="background-image: url({{ asset('/uploads/images/banner/'.$one->image) }}); opacity: 0;" id="mainBanner{{ $i }}"></li>
                    @endif
                <?php $i++; ?>
            @endforeach
        </ul>

        <div class="mainBannerPointer">
            <div class="mainBannerPointerContainer">
                <?php $i=1; ?>
                @foreach($bannerData as $one)
                    @if($i == 1)
                        <div class="mainBannerDot mainBannerDotSel" banner="{{ $i }}" id="mainDot{{ $i }}"></div>
                    @else
                        <div class="mainBannerDot" banner="{{ $i }}" id="mainDot{{ $i }}"></div>
                    @endif
                    <?php $i++; ?>
                @endforeach
            </div>
        </div>
    </div>

    <!--产品部分-->
    <div class="indexProduct">
        @foreach($productData as $two)
            <div class="indexProductOne">
                <h2><a href="/product/list/{{ $two->id }}">{{ $two->showName }}</a></h2>
                <h3><a href="/product/list/{{ $two->id }}">{{ $two->name }}</a></h3>
                <img src="{{ $cc->getImage($two->image, $two->created_at, 'product', true) }}">
                <p>{{ $two->briefIntroduction }}</p>
            </div>
        @endforeach
        <div style="clear: both;"></div>
    </div>

    <!--新闻部分-->
    @if(count($articleData) > 0)
    <div class="indexArticle">
        <div class="left">
            <?php $i=0; ?>
            @foreach($articleData as $three)
                @if($i == 0)
                    <div num="{{ $i }}" class="one active">{{ $three['name'] }}<div class="arrow"></div></div>
                @else
                    <div num="{{ $i }}" class="one">{{ $three['name'] }}<div class="arrow"></div></div>
                @endif
                <?php $i++; ?>
            @endforeach
        </div>

        <div class="right">
            <?php $i=0; ?>
            @foreach($articleData as $four)
                @if($i == 0)
                    <ul num="{{ $i }}" class="active">
                @else
                    <ul num="{{ $i }}">
                @endif

                <?php $l=0; ?>
                @foreach($four['data'] as $five)
                    @if($l == 0)
                        <li class="first">
                            <h3>
                                <a href="/article/detail/{{ $five->id }}">{{ $five->name }}</a>
                                <i>{{ substr($five->publishTime,0,10) }}</i>
                            </h3>
                            <p>{{ $five->abstract }}</p>
                        </li>
                    @else
                        <li>
                            <h3>
                                <a href="/article/detail/{{ $five->id }}">●&nbsp;&nbsp;{{ $five->name }}</a>
                                <i>{{ substr($five->publishTime,0,10) }}</i>
                            </h3>
                        </li>
                    @endif
                    <?php $l++; ?>
                @endforeach

                </ul>

                <?php $i++; ?>
            @endforeach
        </div>
    </div>
    @endif
@endsection

@section('jsContent')
    <script src="{{ asset('/js/site/index.js') }}"></script>
@endsection
