@extends('admin.layouts.master')

@section('cssContent')
    @include('vendor.ueditor.assets')
@endsection

@section('content')
    <div class="panel panel-headline">
        <div class="panel-heading">
            <h3 class="panel-title">产品{{ session('productData') ? '修改' : '添加' }}</h3>
        </div>

        <input type="hidden" id="categoryData" value="{{ $categoryData }}">
        <input type="hidden" id="configData" value="{{ $configData }}">
        <input type="hidden" id="theToken" value="{{ csrf_token() }}">
        <input type="hidden" id="storeRes" value="{{ session('store_res') }}">

        <div class="panel-body">
            <form id="productForm" method="post" action="{{ session('productData') ? '/admin/product/storeModify' : '/admin/product/store' }}">
                {{ csrf_field() }}

                <input type="hidden" id="modifyId" name="modifyId" value="{{ session('productData') ? session('productData')->id : '' }}">

                <div class="form-group">
                    <label for="pCategory">产品分类</label>
                    <input type="hidden" id="initCategory"  value="{{ session('productData') ? session('productData')->categoryId : '' }}">
                    <select class="form-control storeNeed" id="pCategory" name="pCategory" tip="产品分类">
                        <option value="">请选择</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="pTitle">产品名称</label>
                    <input type="text" class="form-control storeNeed" id="pTitle" name="pTitle" placeholder="产品名称" tip="产品名称" value="{{ session('productData') ? session('productData')->name : '' }}">
                </div>

                <input type="hidden" class="storeNeed" id="pImages" name="pImages" tip="产品图片">
                <input type="hidden" class="storeNeed" id="pPhotos" name="pPhotos" tip="产品实拍图">
                <input type="hidden" class="storeNeed" id="pIntroduce" name="pIntroduce" tip="产品卖点">
                <input type="hidden" class="storeNeed" id="pAttr" name="pAttr" tip="性能参数">
            </form>

            <form class="uploadForm" id="pImageForm" action="/commonUploadImage" enctype="multipart/form-data" method="post" style="padding: 10px 0 0;">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="pImageValue">产品图片</label>
                    <div class="uploadImageContainer" id="pImageDiv">
                        @if(session('productData'))
                            <?php $imageArr = explode(',', session('productData')->images); ?>

                            @foreach($imageArr as $imageOne)
                                <div class="uploadImageDiv">
                                    <img src="{{ asset('uploads/images/product/'.$datePath.'/'.$imageOne) }}">
                                    <a filename="{{ $imageOne }}">删除</a>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div>
                        <input type="file" id="pImageValue" name="cuiValue" style="display: inline-block;">
                        <input type="hidden" id="pImagePath" name="cuiPath" value="product/{{ $datePath }}">
                        <button type="button" class="btn btn-sm btn-success" style="display: inline-block;">上 传</button>
                    </div>
                </div>
            </form>

            <form class="uploadForm" id="pPhotoForm" action="/commonUploadImage" enctype="multipart/form-data" method="post" style="padding: 10px 0 0;">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="pPhotoValue">产品实拍图</label>
                    <div class="uploadImageContainer" id="pPhotoDiv">
                        @if(session('productData'))
                            <?php $photoArr = explode(',', session('productData')->photos); ?>

                            @foreach($photoArr as $photoOne)
                                <div class="uploadImageDiv">
                                    <img src="{{ asset('uploads/images/product/'.$datePath.'/'.$photoOne) }}">
                                    <a filename="{{ $photoOne }}">删除</a>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div>
                        <input type="file" id="pPhotoValue" name="cuiValue" style="display: inline-block;">
                        <input type="hidden" id="pPhotoPath" name="cuiPath" value="product/{{ $datePath }}">
                        <button type="button" class="btn btn-sm btn-success" style="display: inline-block;">上 传</button>
                    </div>
                </div>
            </form>

            <div class="form-group">
                <label for="pIntroduce">产品卖点</label>
                <script id="pIntroduces" name="content" type="text/plain">
                    {!! session('productData') ? session('productData')->introduce : '' !!}
                </script>
            </div>

            <div class="form-group">
                <label>性能参数</label>
                <button type="button" id="productAttrAddBtn" class="btn btn-sm btn-success" style="margin-left: 20px;">添 加</button>
                <div id="attrContainer">
                    @if(session('productAttrData') && session('productAttrGroup'))
                        @foreach(session('productAttrGroup') as $groupOne)
                            <table class="table table-bordered product-attr-table">
                                <tbody>
                                <tr>
                                    <td width="50%">型号&nbsp;&nbsp;<a class="product-attr-remove" title="删除"><i class="fa fa-times"></i></a></td>
                                    <td>
                                        <input type="text" class="pcModel" value="{{ $groupOne }}">
                                    </td>
                                </tr>
                                @foreach(session('productAttrData') as $attrOne)
                                    @if($attrOne->name == $groupOne)
                                        <tr>
                                            <td>
                                                {{ $configData[$attrOne->configId] or $attrOne->configId }}
                                            </td>
                                            <td>
                                                <input type="text" class="pcAttr" data-value="{{ $attrOne->configId }}" value="{{ $attrOne->value }}">
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        @endforeach
                    @endif
                </div>
            </div>

            <button type="button" class="btn btn-primary" id="saveBtn">保 存</button>
        </div>
    </div>
@endsection

@section('jsContent')
    <script src="https://cdn.bootcss.com/jquery.form/4.2.1/jquery.form.min.js"></script>
    <script src="{{ asset('/js/product/add.js') }}"></script>
@endsection
