@extends('admin.layouts.master')

@section('content')
    <div class="panel panel-headline">
        <div class="panel-heading">
            <h3 class="panel-title">通用设置</h3>
        </div>

        <input type="hidden" id="store_res" value="{{ session('store_res') }}">

        <div class="panel-body">
            <form id="commonForm" method="post" action="/admin/set/commonStore">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="pSiteName">网站名称</label>
                    <input type="text" class="form-control storeNeed" id="pSiteName" name="pSiteName" placeholder="网站名称" tip="网站名称" value="{{ $setCommonData['site_name'] or '' }}">
                </div>

                <div class="form-group">
                    <label for="pSiteKeywords">网站关键词</label>
                    <input type="text" class="form-control storeNeed" id="pSiteKeywords" name="pSiteKeywords" placeholder="网站关键词" tip="网站关键词" value="{{ $setCommonData['site_keywords'] or '' }}">
                </div>

                <div class="form-group">
                    <label for="pSiteIntroduce">网站介绍</label>
                    <input type="text" class="form-control storeNeed" id="pSiteIntroduce" name="pSiteIntroduce" placeholder="网站介绍" tip="网站介绍" value="{{ $setCommonData['site_introduce'] or '' }}">
                </div>

                <div class="form-group">
                    <label for="pSiteBottom">网站底部内容</label>
                    <input type="text" class="form-control storeNeed" id="pSiteBottom" name="pSiteBottom" placeholder="网站底部内容" tip="网站底部内容" value="{{ $setCommonData['site_bottom'] or '' }}">
                </div>

                <input type="hidden" class="storeNeed" id="pSiteLogo" name="pSiteLogo" tip="网站logo">
                <input type="hidden" class="storeNeed" id="pSiteIcon" name="pSiteIcon" tip="网站icon">
                <input type="hidden" class="storeNeed" id="pSiteQr" name="pSiteQr" tip="微信二维码">
            </form>

            <form class="uploadForm" id="pLogoForm" action="/commonUploadImage" enctype="multipart/form-data" method="post">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="pLogoValue">网站logo</label>
                    <div class="uploadImageContainer" id="pLogoDiv">
                        @if(isset($setCommonData['site_logo']))
                            <div class="uploadImageDiv">
                                <img src="{{ asset('uploads/images/common/'.$setCommonData['site_logo']) }}">
                                <a filename="{{ $setCommonData['site_logo'] }}">删除</a>
                            </div>
                        @endif
                    </div>

                    <div>
                        <input type="file" id="pLogoValue" name="cuiValue" style="display: inline-block;">
                        <input type="hidden" id="pLogoPath" name="cuiPath" value="common">
                        <button type="button" class="btn btn-sm btn-success" style="display: inline-block;">上 传</button>
                    </div>
                </div>
            </form>

            <form class="uploadForm" id="pIconForm" action="/commonUploadImage" enctype="multipart/form-data" method="post">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="pIconValue">网站icon</label>
                    <div class="uploadImageContainer" id="pIconDiv">
                        @if(isset($setCommonData['site_icon']))
                            <div class="uploadImageDiv">
                                <img src="{{ asset('uploads/images/common/'.$setCommonData['site_icon']) }}">
                                <a filename="{{ $setCommonData['site_icon'] }}">删除</a>
                            </div>
                        @endif
                    </div>

                    <div>
                        <input type="file" id="pIconValue" name="cuiValue" style="display: inline-block;">
                        <input type="hidden" id="pIconPath" name="cuiPath" value="common">
                        <button type="button" class="btn btn-sm btn-success" style="display: inline-block;">上 传</button>
                    </div>
                </div>
            </form>

            <form class="uploadForm" id="pQrForm" action="/commonUploadImage" enctype="multipart/form-data" method="post">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="pQrValue">微信二维码</label>
                    <div class="uploadImageContainer" id="pQrDiv">
                        @if(isset($setCommonData['site_qr']))
                            <div class="uploadImageDiv">
                                <img src="{{ asset('uploads/images/common/'.$setCommonData['site_qr']) }}">
                                <a filename="{{ $setCommonData['site_qr'] }}">删除</a>
                            </div>
                        @endif
                    </div>

                    <div>
                        <input type="file" id="pQrValue" name="cuiValue" style="display: inline-block;">
                        <input type="hidden" id="pQrPath" name="cuiPath" value="common">
                        <button type="button" class="btn btn-sm btn-success" style="display: inline-block;">上 传</button>
                    </div>
                </div>
            </form>

            <button type="button" class="btn btn-primary" id="saveBtn">保 存</button>
        </div>
    </div>
@endsection

@section('jsContent')
    <script src="https://cdn.bootcss.com/jquery.form/4.2.1/jquery.form.min.js"></script>
    <script src="{{ asset('/js/set/commonList.js') }}"></script>
@endsection
