<?php
    $routeUri = Route::current()->uri;
?>
<!doctype html>
<html>

<head>
    <title>管理后台-</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <!-- ICONS -->
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('/images/favicon.png') }}">

    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('/lib/linearicons/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/lib/toastr/toastr.min.css') }}">

    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">

    <!-- MAIN CSS -->
    <link rel="stylesheet" href="{{ asset('/css/mainAdmin.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/adminCommon.css') }}">

    @yield('cssContent')

    <script type="text/javascript">
        var commonToken = '{{ csrf_token() }}';
    </script>
</head>

<body>
<input type="hidden" id="routeUri" value="{{ $routeUri }}">
<!-- WRAPPER -->
<div id="wrapper">
    <!-- NAVBAR && LEFT SIDEBAR -->
    @include('admin.dashboard.nav')
    <!-- END NAVBAR && LEFT SIDEBAR -->

    <!-- MAIN -->
    <div class="main">
        <!-- MAIN CONTENT -->
        <div class="main-content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>
    <!-- END MAIN -->

    <div class="clearfix"></div>
</div>

<!-- JS -->
<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="{{ asset('/lib/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('/lib/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('/lib/layer/layer.js') }}"></script>
<script src="{{ asset('/js/adminCommon.js') }}"></script>
@yield('jsContent')
</body>
</html>
