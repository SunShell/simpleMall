@extends('web.layouts.master')

@section('cssContent')
    <link rel="stylesheet" href="{{ asset('/css/service.css') }}">
@endsection

@section('content')
    <div class="mainContainer">
        <div class="serviceTop">
            <h2>热门问题</h2>
            <h3><a href="/service/issue">全部问题</a></h3>
            <ul>
                <?php $i=0; ?>
                @foreach($issueData as $one)
                    @if($i%2==0)
                        <li class="left"><a href="/service/issue/{{ $one->id }}">{{ $one->name }}</a></li>
                    @else
                        <li><a href="/service/issue/{{ $one->id }}">{{ $one->name }}</a></li>
                    @endif
                    <?php $i++; ?>
                @endforeach
            </ul>
        </div>

        <div class="serviceBottom">
            <div class="left">
                <h2>服务网点</h2>
                <h3>丰富线下服务网点，一站式解决你的问题</h3>
                <h4><a href="/service/vendor">全部网点</a></h4>
                <img src="{{ asset('images/s1.png') }}">
            </div>

            <div class="right">
                <h2>经销商系统</h2>
                <h3>经销商授权查询系统，轻松解决产品验证问题</h3>
                <h4><a href="/service/vendor">经销商查询</a></h4>
                <img src="{{ asset('images/s2.png') }}">
            </div>
        </div>
    </div>
@endsection
