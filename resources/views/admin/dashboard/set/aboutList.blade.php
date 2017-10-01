@extends('admin.layouts.master')

@section('cssContent')
    @include('vendor.ueditor.assets')
@endsection

@section('content')
    <div class="panel panel-headline">
        <div class="panel-heading">
            <h3 class="panel-title">关于我们管理</h3>
        </div>

        <input type="hidden" id="store_res" value="{{ session('store_res') }}">

        <div class="panel-body">
            <form id="aboutForm" method="post" action="/admin/set/aboutStore">
                {{ csrf_field() }}

                <input type="hidden" class="storeNeed" id="pImage" name="pImage" tip="顶部图片">
                <input type="hidden" class="storeNeed" id="pContent" name="pContent" tip="企业简介">
            </form>

            <form class="uploadForm" id="pImageForm" action="/commonUploadImage" enctype="multipart/form-data" method="post">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="pImageValue">顶部图片</label>
                    <div class="uploadImageContainer" id="pImageDiv">
                        @if(isset($setAboutData->image))
                            <?php $imageArr = explode(',', $setAboutData->image); ?>

                            @foreach($imageArr as $imageOne)
                                <div class="uploadImageDiv">
                                    <img src="{{ asset('uploads/images/about/'.$imageOne) }}">
                                    <a filename="{{ $imageOne }}">删除</a>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <div>
                        <input type="file" id="pImageValue" name="cuiValue" style="display: inline-block;">
                        <input type="hidden" id="pImagePath" name="cuiPath" value="about">
                        <button type="button" class="btn btn-sm btn-success" style="display: inline-block;">上 传</button>
                    </div>
                </div>
            </form>

            <div class="form-group">
                <label for="pContents">企业简介</label>
                <script id="pContents" name="pContents" type="text/plain">
                    {!! $setAboutData->content or '' !!}
                </script>
            </div>

            <button type="button" class="btn btn-primary" id="saveBtn">保 存</button>
        </div>
    </div>
@endsection

@section('jsContent')
    <script src="https://cdn.bootcss.com/jquery.form/4.2.1/jquery.form.min.js"></script>
    <script src="{{ asset('/js/set/aboutList.js') }}"></script>
@endsection
