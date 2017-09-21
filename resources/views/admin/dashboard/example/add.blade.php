@extends('admin.layouts.master')

@section('cssContent')
    @include('vendor.ueditor.assets')
@endsection

@section('content')
    <div class="panel panel-headline">
        <div class="panel-heading">
            <h3 class="panel-title">案例{{ session('exampleData') ? '修改' : '添加' }}</h3>
        </div>

        <input type="hidden" id="categoryData" value="{{ $categoryData }}">
        <input type="hidden" id="theToken" value="{{ csrf_token() }}">
        <input type="hidden" id="storeRes" value="{{ session('store_res') }}">

        <div class="panel-body">
            <form id="exampleForm" method="post" action="{{ session('exampleData') ? '/admin/example/storeModify' : '/admin/example/store' }}">
                {{ csrf_field() }}

                <input type="hidden" id="modifyId" name="modifyId" value="{{ session('exampleData') ? session('exampleData')->id : '' }}">

                <div class="form-group">
                    <label for="pCategory">案例分类</label>
                    <input type="hidden" id="initCategory"  value="{{ session('exampleData') ? session('exampleData')->categoryId : '' }}">
                    <select class="form-control storeNeed" id="pCategory" name="pCategory" tip="案例分类">
                        <option value="">请选择</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="pName">案例名称</label>
                    <input type="text" class="form-control storeNeed" id="pName" name="pName" placeholder="案例名称" tip="案例名称" value="{{ session('exampleData') ? session('exampleData')->name : '' }}">
                </div>

                <input type="hidden" class="storeNeed" id="pImage" name="pImage" tip="案例图片">
                <input type="hidden" class="storeNeed" id="pContent" name="pContent" tip="案例详情">
            </form>

            <form class="uploadForm" id="pImageForm" action="/commonUploadImage" enctype="multipart/form-data" method="post" style="padding: 10px 0 0;">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="pImageValue">案例图片</label>
                    <div class="uploadImageContainer" id="pImageDiv">
                        @if(session('exampleData'))
                            <?php $imageArr = explode(',', session('exampleData')->image); ?>

                            @foreach($imageArr as $imageOne)
                                <div class="uploadImageDiv">
                                    <img src="{{ asset('uploads/images/example/'.$datePath.'/'.$imageOne) }}">
                                    <a filename="{{ $imageOne }}">删除</a>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div>
                        <input type="file" id="pImageValue" name="cuiValue" style="display: inline-block;">
                        <input type="hidden" id="pImagePath" name="cuiPath" value="example/{{ $datePath }}">
                        <button type="button" class="btn btn-sm btn-success" style="display: inline-block;">上 传</button>
                    </div>
                </div>
            </form>

            <div class="form-group">
                <label for="pContents">案例详情</label>
                <script id="pContents" name="pIntroduces" type="text/plain">
                    {!! session('exampleData') ? session('exampleData')->content : '' !!}
                </script>
            </div>

            <button type="button" class="btn btn-primary" id="saveBtn">保 存</button>
        </div>
    </div>
@endsection

@section('jsContent')
    <script src="https://cdn.bootcss.com/jquery.form/4.2.1/jquery.form.min.js"></script>
    <script src="{{ asset('/js/example/add.js') }}"></script>
@endsection
