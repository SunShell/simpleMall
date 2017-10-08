<?php
use App\Http\Controllers\ConfigController;

$wcc = new ConfigController();
?>
<html>
<head>
    <meta charset="utf-8">
    <title>404-{{ $wcc->getWebsiteConfig('site_name') }}</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/404.css') }}" />
</head>

<body>

<div class="newfinno-con"></div>

<div class="tips">
    <h2 class="b-text">矮油~~您访问的页面不在地球上...</h2>
    <p class="m-box">
        <span class="m-text">休息一下，继续浏览我们的网站！</span>
        <a class="back-index" href="/">返回首页</a>
    </p>
</div>

</body>
</html>
