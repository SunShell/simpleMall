<?php
    use App\Http\Controllers\ConfigController;

    $wcc = new ConfigController();

    $siteName = $wcc->getWebsiteConfig('site_name');
?>
<!doctype html>
<html class="fullscreen-bg">

<head>
    <title>登录-管理后台-{{ $siteName }}</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <!-- ICONS -->
    <link rel="icon" type="image/png" sizes="96x96" href="{{ $wcc->getWebsiteConfig('site_icon') }}">

    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('/lib/toastr/toastr.min.css') }}">

    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">

    <!-- MAIN CSS -->
    <link rel="stylesheet" href="{{ asset('/css/mainAdmin.css') }}">
</head>

<body class="login-body">
<!-- WRAPPER -->
<div id="wrapper">
    <div class="vertical-align-wrap">
        <div class="vertical-align-middle">
            <div class="auth-box ">
                <div class="left">
                    <div class="content">
                        <div class="header">
                            <div class="logo text-center"><img src="{{ asset($wcc->getWebsiteConfig('site_logo')) }}" alt="公司logo" style="max-height: 53px;"></div>
                            <p class="lead">后台登录</p>
                        </div>

                        <form class="form-auth-small" method="post" action="/admin/login">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="login_id" class="control-label sr-only">用户名</label>
                                <input type="text" class="form-control" id="login_id" name="login_id" placeholder="用户名" autofocus>
                            </div>

                            <div class="form-group">
                                <label for="login_password" class="control-label sr-only">密码</label>
                                <input type="password" class="form-control" id="login_password" name="login_password" placeholder="密码">
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg btn-block">登&nbsp;&nbsp;录</button>
                        </form>
                    </div>
                </div>
                <div class="right">
                    <div class="overlay"></div>

                    <div class="content text">
                        <h1 class="heading">{{ $siteName or '公司名称' }}</h1>
                        <p>管理后台</p>
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
<!-- END WRAPPER -->

<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
<script src="{{ asset('/lib/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('/lib/toastr/toastr.min.js') }}"></script>

@include('admin.layouts.errors')
</body>

</html>