@extends('web.layouts.master')

@section('content')
<div class="mainContainer">
    <div class="mainNav">
        <ul>
            <li class="title">关于我们</li>
            <li><a class="active" href="/about">企业简介</a></li>
            <li><a href="/culture">企业文化</a></li>
        </ul>
    </div>

    <div class="mainContent">
        <div class="aboutImage">
            <?php
            $images = explode(',', $aboutData->image);
            $iLen = count($images);
            ?>

            @if($iLen > 1)
                @for($i=0;$i<$iLen;$i++)
                    @if($i==0)
                        <img style="float: left; width: 49%;" src="{{ asset("/uploads/images/about/".$images[$i]) }}">
                    @else
                        <img style="float: right; width: 49%;" src="{{ asset("/uploads/images/about/".$images[$i]) }}">
                    @endif
                @endfor
                <div class="mainClear"></div>
            @else
                <img style="max-width: 100%;" src="{{ asset("/uploads/images/about/".$images[0]) }}">
            @endif
        </div>

        <div class="aboutContent">
            {!! $aboutData->content !!}
        </div>
    </div>

    <div class="mainClear"></div>
</div>
@endsection
