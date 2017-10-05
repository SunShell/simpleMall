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
            @if(isset($exampleData[$key]))
                <div class="categoryPart">
                    <div class="categoryTitle">
                        {{ $value }}
                        <a href="/example/list/{{ $key }}">更多>></a>
                    </div>

                    <div class="categoryList">
                        <?php $style = 'style="margin-left: 0;"'; ?>
                        @foreach($exampleData[$key] as $one)
                            <div class="categoryOne" exampleId="{{ $one->id }}" {!! $style !!}>
                                <div class="categoryImgBig"><img src="{{ $cc->getImage($one->image,$one->created_at,'example',true) }}"></div>
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
    <script src="{{ asset('/js/site/example.js') }}"></script>
@endsection
