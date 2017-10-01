@extends('admin.layouts.master')

@section('content')
    <div class="panel panel-headline">
        <div class="panel-heading">
            <h3 class="panel-title">概览</h3>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-3 indexNumDiv" hrefData="/admin/product/list">
                    <div class="metric">
                        <span class="icon"><i class="fa fa-shopping-bag"></i></span>
                        <p>
                            <span class="number">{{ $numObj['productNum'] }}</span>
                            <span class="title">产品</span>
                        </p>
                    </div>
                </div>

                <div class="col-md-3 indexNumDiv" hrefData="/admin/example/list">
                    <div class="metric">
                        <span class="icon"><i class="fa fa-tasks"></i></span>
                        <p>
                            <span class="number">{{ $numObj['exampleNum'] }}</span>
                            <span class="title">案例</span>
                        </p>
                    </div>
                </div>

                <div class="col-md-3 indexNumDiv" hrefData="/admin/article/list">
                    <div class="metric">
                        <span class="icon"><i class="fa fa-newspaper-o"></i></span>
                        <p>
                            <span class="number">{{ $numObj['articleNum'] }}</span>
                            <span class="title">新闻</span>
                        </p>
                    </div>
                </div>

                <div class="col-md-3 indexNumDiv" hrefData="/admin/set/message">
                    <div class="metric">
                        <span class="icon"><i class="fa fa-envelope"></i></span>
                        <p>
                            <span class="number">{{ $numObj['messageNum'] }}</span>
                            <span class="title">留言</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('jsContent')
    <script src="{{ asset('/js/adminIndex.js') }}"></script>
@endsection
