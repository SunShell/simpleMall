<?php
    use App\Http\Controllers\ConfigController;

    $wcc = new ConfigController();

    $navs = $wcc->getWebsiteNav();
?>
<!doctype html>
<html>

<head>
    <title>{{ $pageName.'-'.$wcc->getWebsiteConfig('site_name') }}</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="keywords" content="{{ $wcc->getWebsiteConfig('site_keywords') }}" />
    <meta name="description" content="{{ $wcc->getWebsiteConfig('site_introduce') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- ICONS -->
    <link rel="icon" type="image/png" sizes="96x96" href="{{ $wcc->getWebsiteConfig('site_icon') }}">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('/lib/linearicons/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/mainWeb.css') }}">

    @yield('cssContent')
</head>

<body>
@include('web.site.nav')

<div class="commonContainer">
@yield('content')
</div>

@include('web.site.footer')

<!-- JS -->
<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
<script src="{{ asset('/lib/layer/layer.js') }}"></script>
<script src="{{ asset('/js/mainWeb.js') }}"></script>
@yield('jsContent')
</body>
</html>
