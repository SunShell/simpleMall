<nav class="navbar navbar-default navbar-fixed-top">
    <div class="brand">
        <a href="/admin"><img src="{{ asset('/images/logo-dark.png') }}" alt="公司logo" class="img-responsive logo"></a>
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
                            <li><a href="/admin/product/add"><i class="fa fa-shopping-basket"></i> <span>产品添加</span></a></li>
                            <li><a href="/admin/product/list"><i class="fa fa-shopping-cart"></i> <span>产品列表</span></a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
</div>
