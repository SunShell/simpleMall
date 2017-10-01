@extends('admin.layouts.master')

@section('cssContent')
    @include('vendor.ueditor.assets')
@endsection

@section('content')
    <div class="panel panel-headline">
        <div class="panel-heading">
            <h3 class="panel-title">新闻{{ session('articleData') ? '修改' : '添加' }}</h3>
        </div>

        <input type="hidden" id="categoryData" value="{{ $categoryData }}">
        <input type="hidden" id="theToken" value="{{ csrf_token() }}">
        <input type="hidden" id="storeRes" value="{{ session('store_res') }}">

        <div class="panel-body">
            <form id="exampleForm" method="post" action="{{ session('articleData') ? '/admin/article/storeModify' : '/admin/article/store' }}">
                {{ csrf_field() }}

                <input type="hidden" id="modifyId" name="modifyId" value="{{ session('articleData') ? session('articleData')->id : '' }}">

                <div class="form-group">
                    <label for="pCategory">分类</label>
                    <input type="hidden" id="initCategory"  value="{{ session('articleData') ? session('articleData')->categoryId : '' }}">
                    <select class="form-control storeNeed" id="pCategory" name="pCategory" tip="分类">
                        <option value="">请选择</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="pName">标题</label>
                    <input type="text" class="form-control storeNeed" id="pName" name="pName" placeholder="标题" tip="标题" value="{{ session('articleData') ? session('articleData')->name : '' }}">
                </div>

                <div class="form-group">
                    <label for="pAbstract">摘要</label>
                    <textarea class="form-control storeNeed" id="pAbstract" name="pAbstract" placeholder="摘要" tip="摘要" rows="3" style="resize: none;">{{ session('articleData') ? session('articleData')->abstract : '' }}</textarea>
                </div>

                <input type="hidden" class="storeNeed" id="pImage" name="pImage" tip="列表页展示图片">
                <input type="hidden" class="storeNeed" id="pContent" name="pContent" tip="内容">
            </form>

            <form class="uploadForm" id="pImageForm" action="/commonUploadImage" enctype="multipart/form-data" method="post" style="padding: 10px 0 0;">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="pImageValue">列表页展示图片</label>
                    <div class="uploadImageContainer" id="pImageDiv">
                        @if(session('articleData'))
                            <?php $imageArr = explode(',', session('articleData')->image); ?>

                            @foreach($imageArr as $imageOne)
                                <div class="uploadImageDiv">
                                    <img src="{{ asset('uploads/images/article/'.$datePath.'/'.$imageOne) }}">
                                    <a filename="{{ $imageOne }}">删除</a>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div>
                        <input type="file" id="pImageValue" name="cuiValue" style="display: inline-block;">
                        <input type="hidden" id="pImagePath" name="cuiPath" value="article/{{ $datePath }}">
                        <button type="button" class="btn btn-sm btn-success" style="display: inline-block;">上 传</button>
                    </div>
                </div>
            </form>

            <div class="form-group">
                <label for="pContents">内容</label>
                <script id="pContents" name="pContents" type="text/plain">
                    {!! session('articleData') ? session('articleData')->content : '' !!}
                </script>
            </div>

            <button type="button" class="btn btn-primary" id="saveBtn">保 存</button>
        </div>
    </div>
@endsection

@section('jsContent')
    <script src="https://cdn.bootcss.com/jquery.form/4.2.1/jquery.form.min.js"></script>
    <script src="{{ asset('/js/article/add.js') }}"></script>
@endsection
