<?php
use App\Http\Controllers\ConfigController;

$cc = new ConfigController();
?>

@extends('web.layouts.master')

@section('cssContent')
    <link rel="stylesheet" href="{{ asset('/lib/vm-carousel/jquery.vm-carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/product.css') }}">
@endsection

@section('content')
    <div class="mainContainer">
        <div class="mainNav">
            <ul>
                <li class="title">{{ $pageName }}</li>
                @foreach($categoryData as $key => $val)
                    @if($key == $productData->categoryId)
                        <li><a class="active" href="/product/list/{{ $key }}">{{ $val }}</a></li>
                    @else
                        <li><a href="/product/list/{{ $key }}">{{ $val }}</a></li>
                    @endif
                @endforeach
            </ul>
        </div>

        <div class="mainContent">
            <div class="detailTitle">{{ $productData->name }}</div>

            <div class="detailImg">
                <div class="leftImg">
                    <img class="imageBig" src="{{ $cc->getImage($productData->images,$productData->created_at,'product',true) }}">
                </div>

                <div class="rightImg">
                    <div class="upDown up"></i></div>
                    <div class="imageAll">
                        <?php $images = $cc->getImage($productData->images,$productData->created_at,'product'); ?>
                        <div class="imageMove">
                        @foreach($images as $image)
                            <img class="imageSmall" src="{{ $image }}">
                        @endforeach
                        </div>
                    </div>
                    <div class="upDown down"></div>
                </div>

                <div class="mainClear"></div>
            </div>

            <div class="detailTit">产品实拍图</div>

            <div class="detailPhoto">
                <ul class="photoAll">
                    <?php $photos = $cc->getImage($productData->photos,$productData->created_at,'product'); ?>
                        @foreach($photos as $photo)
                            <li><img class="photoOne" src="{{ $photo }}"></li>
                        @endforeach
                </ul>
            </div>

            <div class="detailTit">产品卖点</div>

            <div class="detailContent">{!! $productData->introduce !!}</div>

            <div class="detailTit">性能参数</div>

            <div class="detailAttr">
                <table>
                    <tbody>
                    @for($i=0;$i<count($configGroup);$i++)
                        @if($i == 0)
                            <tr>
                                <td class="title left">型号</td>
                                @foreach($attrGroup as $tmpOne)
                                    <td class="title">{{ $tmpOne }}</td>
                                @endforeach
                            </tr>
                        @endif

                        <tr>
                            <td class="left">{{ $configData[$configGroup[$i]] }}</td>
                            @foreach($attrGroup as $tmpOne)
                                @foreach($attrData as $tmpTwo)
                                    @if($tmpTwo->name == $tmpOne && $tmpTwo->configId == $configGroup[$i])
                                        <td>{{ $tmpTwo->value }}</td>
                                    @endif
                                @endforeach
                            @endforeach
                        </tr>
                    @endfor
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mainClear"></div>
    </div>
@endsection

@section('jsContent')
    <script src="https://cdn.bootcss.com/modernizr/2.8.3/modernizr.min.js"></script>
    <script src="{{ asset('/lib/vm-carousel/jquery.vm-carousel.js') }}"></script>
    <script src="{{ asset('/js/site/productDetail.js') }}"></script>
@endsection
