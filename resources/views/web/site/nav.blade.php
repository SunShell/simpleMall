<div class="smSiteTop">
    <div class="topContainer">
        <div class="blueDiv">
            <ul>
                <li>联系电话：{{ $wcc->getWebsiteContact('phone') }}</li>
            </ul>
        </div>

        <div class="logoDiv">
            <img src="{{ asset($wcc->getWebsiteConfig('site_logo')) }}">
        </div>

        <div class="navDiv">
            <ul>
                @foreach($navs as $id => $nav)
                    @if($id == $pageId)
                        <li class="activeNav"><a href="/{{ $id == 'index' ? '' : $id }}">{{ $nav }}</a></li>
                    @else
                        <li><a href="/{{ $id == 'index' ? '' : $id }}">{{ $nav }}</a></li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</div>

@if($pageId != 'index')
    <div class="commonBannerDiv"></div>

    <div class="commonNavDiv">
        <ul>
            <li><a href="/">首页</a></li>
            <li>></li>
            @if(isset($pageSub))
                <li><a href="/{{ $pageId }}">{{ $pageName }}</a></li>
                @foreach($pageSub as $pageSubOne)
                    <li>></li>
                    @if(isset($pageSubOne['route']))
                        <li><a href="{{ $pageSubOne['route'] }}">{{ $pageSubOne['name'] }}</a></li>
                    @else
                        <li>{{ $pageSubOne['name'] }}</li>
                    @endif
                @endforeach
            @else
                <li>{{ $pageName }}</li>
            @endif
        </ul>
    </div>
@endif
