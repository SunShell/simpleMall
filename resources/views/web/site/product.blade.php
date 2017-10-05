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
            @if(isset($productData[$key]))
            <div class="categoryPart">
                <div class="categoryTitle">
                    {{ $value }}
                    <a href="/product/list/{{ $key }}">更多>></a>
                </div>

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
            </div>
            @endif
        @endforeach
    </div>
@endsection

@section('jsContent')
    <script src="{{ asset('/js/site/product.js') }}"></script>
@endsection
