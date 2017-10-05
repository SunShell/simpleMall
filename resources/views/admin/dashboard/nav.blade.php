<nav class="navbar navbar-default navbar-fixed-top">
    <div class="brand">
        <a href="/admin"><img src="{{ $wcc->getWebsiteConfig('site_logo') }}" alt="公司logo" class="img-responsive logo" style="height: 53px;"></a>
    </div>

    <div class="container-fluid">
        <div class="navbar-btn">
            <button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
        </div>

        <div id="navbar-menu">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ asset('/images/user.png') }}" class="img-circle" alt="{{ Auth::user()->name }}">
                        <span>{{ Auth::user()->name }}</span>
                        <i class="icon-submenu lnr lnr-chevron-down"></i>
                    </a>

                    <ul class="dropdown-menu">
                        <li><a id="modifyPwd" style="cursor: pointer;"><i class="lnr lnr-lock"></i> <span>修改密码</span></a></li>
                        <li><a href="/admin/logout"><i class="lnr lnr-exit"></i> <span>退出</span></a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div id="sidebar-nav" class="sidebar">
    <div class="sidebar-scroll">
        <nav>
            <ul class="nav">
                <li>
                    <a href="/admin" class="active"><i class="fa fa-home"></i> <span>首页</span></a>
                </li>

                <li>
                    <a href="#subProducts" data-toggle="collapse" class="collapsed">
                        <i class="fa fa-shopping-bag"></i> <span>产品</span>
                        <i class="icon-submenu lnr lnr-chevron-left"></i>
                    </a>

                    <div id="subProducts" class="collapse">
                        <ul class="nav">
                            <li><a href="/admin/product/categoryList"><i class="fa fa-sitemap"></i> <span>分类管理</span></a></li>
                            <li><a href="/admin/product/configList"><i class="fa fa-cube"></i> <span>参数管理</span></a></li>
                            <li><a href="/admin/product/add"><i class="fa fa-plus-square"></i> <span>产品添加</span></a></li>
                            <li><a href="/admin/product/list"><i class="fa fa-list"></i> <span>产品列表</span></a></li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#subService" data-toggle="collapse" class="collapsed">
                        <i class="fa fa-thumbs-up"></i> <span>服务与支持</span>
                        <i class="icon-submenu lnr lnr-chevron-left"></i>
                    </a>

                    <div id="subService" class="collapse">
                        <ul class="nav">
                            <li><a href="/admin/service/issueList"><i class="fa fa-question-circle"></i> <span>问题管理</span></a></li>
                            <li><a href="/admin/service/vendorList"><i class="fa fa-street-view"></i> <span>经销商管理</span></a></li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#subExample" data-toggle="collapse" class="collapsed">
                        <i class="fa fa-tasks"></i> <span>案例</span>
                        <i class="icon-submenu lnr lnr-chevron-left"></i>
                    </a>

                    <div id="subExample" class="collapse">
                        <ul class="nav">
                            <li><a href="/admin/example/categoryList"><i class="fa fa-sitemap"></i> <span>分类管理</span></a></li>
                            <li><a href="/admin/example/add"><i class="fa fa-plus-square"></i> <span>案例添加</span></a></li>
                            <li><a href="/admin/example/list"><i class="fa fa-list"></i> <span>案例列表</span></a></li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#subArticle" data-toggle="collapse" class="collapsed">
                        <i class="fa fa-newspaper-o"></i> <span>新闻</span>
                        <i class="icon-submenu lnr lnr-chevron-left"></i>
                    </a>

                    <div id="subArticle" class="collapse">
                        <ul class="nav">
                            <li><a href="/admin/article/categoryList"><i class="fa fa-sitemap"></i> <span>分类管理</span></a></li>
                            <li><a href="/admin/article/add"><i class="fa fa-plus-square"></i> <span>新闻添加</span></a></li>
                            <li><a href="/admin/article/list"><i class="fa fa-list"></i> <span>新闻列表</span></a></li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#subSet" data-toggle="collapse" class="collapsed">
                        <i class="fa fa-cogs"></i> <span>设置</span>
                        <i class="icon-submenu lnr lnr-chevron-left"></i>
                    </a>

                    <div id="subSet" class="collapse">
                        <ul class="nav">
                            <li><a href="/admin/set/banner"><i class="fa fa-image"></i> <span>首页轮播图</span></a></li>
                            <li><a href="/admin/set/common"><i class="fa fa-cog"></i> <span>通用设置</span></a></li>
                            <li><a href="/admin/set/about"><i class="fa fa-info-circle"></i> <span>关于我们</span></a></li>
                            <li><a href="/admin/set/contact"><i class="fa fa-phone"></i> <span>联系方式</span></a></li>
                            <li><a href="/admin/set/message"><i class="fa fa-envelope"></i> <span>留言管理</span></a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
</div>
