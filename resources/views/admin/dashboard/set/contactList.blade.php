@extends('admin.layouts.master')

@section('cssContent')
    @include('vendor.ueditor.assets')
@endsection

@section('content')
    <div class="panel panel-headline">
        <div class="panel-heading">
            <h3 class="panel-title">联系方式管理</h3>
        </div>

        <input type="hidden" id="store_res" value="{{ session('store_res') }}">

        <div class="panel-body">
            <form id="contactForm" method="post" action="/admin/set/contactStore">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="pPhone">电话</label>
                    <input type="text" class="form-control storeNeed" id="pPhone" name="pPhone" placeholder="电话" tip="电话" value="{{ $setContactData ? $setContactData->phone : '' }}">
                </div>

                <div class="form-group">
                    <label for="pFax">传真</label>
                    <input type="text" class="form-control storeNeed" id="pFax" name="pFax" placeholder="传真" tip="传真" value="{{ $setContactData ? $setContactData->fax : '' }}">
                </div>

                <div class="form-group">
                    <label for="pEmail">邮箱</label>
                    <input type="text" class="form-control storeNeed" id="pEmail" name="pEmail" placeholder="邮箱" tip="邮箱" value="{{ $setContactData ? $setContactData->email : '' }}">
                </div>

                <div class="form-group">
                    <label for="pAddress">地址</label>
                    <input type="text" class="form-control storeNeed" id="pAddress" name="pAddress" placeholder="地址" tip="地址" value="{{ $setContactData ? $setContactData->address : '' }}">
                </div>

                <button type="button" class="btn btn-primary" id="saveBtn">保 存</button>
            </form>
        </div>
    </div>
@endsection

@section('jsContent')
    <script src="{{ asset('/js/set/contactList.js') }}"></script>
@endsection
