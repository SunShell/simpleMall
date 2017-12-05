@extends('web.layouts.master')

@section('cssContent')
    <link rel="stylesheet" href="{{ asset('/css/service.css') }}">
@endsection

@section('content')
    <div class="mainContainer">
        <div class="mainNav">
            <ul>
                <li class="title">{{ $pageName }}</li>
                <li><a href="/service/issue">热门问题</a></li>
                <li><a class="active" href="/service/vendor">经销商查询</a></li>
            </ul>
        </div>

        <div class="mainContent">
            <div class="serviceContainer">
                <h3>经销商查询</h3>

                <div class="vendorContent">
                    <input type="hidden" id="theToken" value="{{ csrf_token() }}">
                    <input type="hidden" id="imagePath" value="{{ asset('/uploads/images/service') }}">

                    <div>
                        <label for="vendorNumber">经销商编号</label>&nbsp;&nbsp;
                        <input type="text" id="vendorNumber">
                    </div>

                    <div>
                        <label for="vendorName">经销商名称</label>&nbsp;&nbsp;
                        <input type="text" id="vendorName">
                    </div>

                    <button id="queryBtn">查&nbsp;&nbsp;&nbsp;&nbsp;询</button>
                </div>

                <p style="color: #595757;">请输入经销商编号和经销商名称，例如：“大上电器青岛市***专卖店”，您需要在经销商编号一栏输入“D000***1”，经销商名称一栏输入“大上电器青岛市***专卖店”，然后点击查询，就可以查询到相关信息。</p>

                <div class="vendorImg" id="queryRes"></div>

                <p>
                    大上产品一直以稳定良好的性能表现、卓越设计及高质量而闻名。大上集团一直以来非常重视客户的意见和产品质量的反馈。
                    <i>近来，公司发现一些大上产品是通过非大上公司签约的销售渠道出去的，这些产品可能经过改装，会导致一些技术品质上的问题，给您带来不必要的麻烦和损失。</i>
                    所以，推荐您选择与大上正式签约的经销商购买我们的产品！因为大上签约的经销商不但得到了授权，还接受了专业培训，严格按照公司要求进行品牌宣传、产品销售和提供服务！
                </p>
            </div>
        </div>

        <div class="mainClear"></div>
    </div>
@endsection

@section('jsContent')
    <script src="{{ asset('/js/site/vendor.js') }}"></script>
@endsection
