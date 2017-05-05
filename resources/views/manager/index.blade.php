@extends("layouts.manager")
@section("title","UR Manager")

@section("content")
    <div id="page-content">
        <!-- First Row -->
        <div class="row">
            <!-- Simple Stats Widgets -->
            <div class="col-sm-6 col-lg-3">
                <a href="javascript:void(0)" class="widget">
                    <div class="widget-content widget-content-mini text-right clearfix">
                        <div class="widget-icon pull-left themed-background">
                            <i class="gi gi-cardio text-light-op"></i>
                        </div>
                        <h2 class="widget-heading h3">
                            <strong><span data-toggle="counter" data-to="2836"></span></strong>
                        </h2>
                        <span class="text-muted">词汇总量(已根据变量名去重)</span>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-lg-3">
                <a href="javascript:void(0)" class="widget">
                    <div class="widget-content widget-content-mini text-right clearfix">
                        <div class="widget-icon pull-left themed-background-success">
                            <i class="gi gi-cardio text-light-op"></i>
                        </div>
                        <h2 class="widget-heading h3 text-success">
                            <strong>+ <span data-toggle="counter" data-to="2862"></span></strong>
                        </h2>
                        <span class="text-muted">更新/本周</span>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-lg-3">
                <a href="javascript:void(0)" class="widget">
                    <div class="widget-content widget-content-mini text-right clearfix">
                        <div class="widget-icon pull-left themed-background-warning">
                            <i class="gi gi-cardio text-light-op"></i>
                        </div>
                        <h2 class="widget-heading h3 text-warning">
                            <strong>+ <span data-toggle="counter" data-to="75"></span></strong>
                        </h2>
                        <span class="text-muted">新增/本周</span>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-lg-3">
                <a href="javascript:void(0)" class="widget">
                    <div class="widget-content widget-content-mini text-right clearfix">
                        <div class="widget-icon pull-left themed-background-danger">
                            <i class="gi gi-cardio text-light-op"></i>
                        </div>
                        <h2 class="widget-heading h3 text-danger">
                            <strong>+ <span data-toggle="counter" data-to="5820"></span></strong>
                        </h2>
                        <span class="text-muted">待处理</span>
                    </div>
                </a>
            </div>
            <!-- END Simple Stats Widgets -->
        </div>
        <!-- END First Row -->

        <!-- Second Row -->
        <div class="row">

            @foreach(config("app.person") as $user)
                <div class="col-sm-6 col-lg-3">
                    <!-- Stats User Widget -->
                    <a href="page_ready_profile.html" class="widget">
                        <div class="widget-content border-bottom text-dark">
                            <span class="pull-right text-muted">本周</span>
                            责任者
                        </div>
                        <div class="widget-content border-bottom text-center themed-background-muted">
                            <img src="img/placeholders/avatars/avatar13@2x.jpg" alt="avatar" class="img-circle img-thumbnail img-thumbnail-avatar-2x">
                            <h2 class="widget-heading h3 text-dark">{{ $user }}</h2>
                        <span class="text-muted">
                            <strong>Logo Designer</strong>, Sweden
                        </span>
                        </div>
                        <div class="widget-content widget-content-full-top-bottom">
                            <div class="row text-center">
                                <div class="col-xs-6 push-inner-top-bottom border-right">
                                    <h3 class="widget-heading">
                                        <i class="gi gi-briefcase text-dark push-bit"></i>
                                        <br>
                                        <small>35 词汇合计</small>
                                    </h3>
                                </div>
                                <div class="col-xs-6 push-inner-top-bottom">
                                    <h3 class="widget-heading">
                                        <i class="gi gi-heart_empty text-dark push-bit"></i>
                                        <br>
                                        <small>84 待处理</small>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </a>
                    <!-- END Stats User Widget -->
                </div>
            @endforeach
        </div>
    </div>
@stop