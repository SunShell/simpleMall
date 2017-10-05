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
        @foreach($categoryData as $key => $value)
            <div class="categoryPart">
                <div class="categoryTitle">
                    {{ $value }}
                    <a href="/product/list/{{ $key }}">更多>></a>
                </div>

                @if($productData[$key])
                    <div class="categoryList">
                        <?php $style = 'style="margin-left: 0;"'; ?>
                        @foreach($productData[$key] as $one)
                            <div class="categoryOne" productId="{{ $one->id }}" {!! $style !!}>
                                <div class="categoryImg"><img src="{{ $cc->getImage($one->images,$one->created_at,'product',true) }}"></div>
                                {{ $one->name }}
                            </div>
                            <?php $style=''; ?>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </div>
@endsection

@section('jsContent')
    <script src="{{ asset('/js/site/product.js') }}"></script>
@endsection
