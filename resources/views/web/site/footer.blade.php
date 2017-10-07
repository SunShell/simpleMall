<div class="smSiteBottom">
    <div class="bottomContainer">
        <div class="bottomLeft">
            <img src="{{ asset("/images/qrBorderTop.png") }}">
            <img class="qrImg" src="{{ asset($wcc->getWebsiteConfig('site_qr')) }}">
            <p>官方微信</p>
        </div>

        <div class="bottomCenter">
            <ul>
                <li><h3>联系我们</h3></li>
                <li>咨询热线：{{ $wcc->getWebsiteContact('phone') }}</li>
                <li><span>传真</span>：{{ $wcc->getWebsiteContact('fax') }}</li>
                <li><span>邮箱</span>：{{ $wcc->getWebsiteContact('email') }}</li>
                <li><span>地址</span>：{{ $wcc->getWebsiteContact('address') }}</li>
            </ul>
        </div>

        <div class="bottomRight">
            <h3>留言信息</h3>
            <input type="hidden" id="bottomMessageToken" value="{{ csrf_token() }}">
            <textarea id="bottomMessageContent" placeholder="请在此输入您的留言内容..."></textarea>
            <button id="bottomMessageSave">提&nbsp;交</button>
            <button id="bottomMessageClear">清&nbsp;除</button>
        </div>
    </div>

    <div class="bottomContainerTwo">
        <p>{{ str_replace(" ","&nbsp;",$wcc->getWebsiteConfig('site_bottom')) }}</p>
    </div>
</div>