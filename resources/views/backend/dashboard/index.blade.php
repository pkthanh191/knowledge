@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1><i class="fa fa-dashboard"></i> @lang('messages.dashboard')</h1>
        {!! Breadcrumbs::render('admin.dashboard.index') !!}
    </section>
    <section class="content">
        <div class="clearfix"></div>
        @include('flash::message')

        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-aqua">
                    <span class="info-box-icon"><i class="fa fa fa-file"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text"><a href="{!! route('admin.documents.index') !!}"
                                                       class="white">@lang('messages.document')</a></span>
                        <span class="info-box-number">{!! $countDocumentRepository !!}</span>
                        <div class="progress">
                            <div class="progress-bar" style="width: 70%"></div>
                        </div>
                        <span class="progress-description">@lang('messages.on-total')
                            <strong>{!! $countCategoryDocumentRepository !!}</strong> @lang('messages.categories').
                        </span>
                    </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-green">
                    <span class="info-box-icon"><i class="fa fa-file-text-o"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text"><a href="{!! route('admin.tests.index') !!}"
                                                       class="white">@lang('messages.test')</a></span>
                        <span class="info-box-number">{!! $countTestRepository !!}</span>
                        <div class="progress">
                            <div class="progress-bar" style="width: 70%"></div>
                        </div>
                        <span class="progress-description">
                            @lang('messages.on-total')
                            <strong>{!! $countTestCategoryRepository !!}</strong> @lang('messages.categories').
                        </span>
                    </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-yellow">
                    <span class="info-box-icon"><i class="fa fa-calendar"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text"><a href="{!! route('admin.centers.index') !!}"
                                                       class="white">@lang('messages.center')</a></span>
                        <span class="info-box-number">{!! $countCenterRepository !!}</span>
                        <div class="progress">
                            <div class="progress-bar" style="width: 70%"></div>
                        </div>
                        <span class="progress-description">
                            @lang('messages.on-total')
                            <strong>{!! $countCourseRepository !!}</strong> @lang('messages.courses').
                        </span>
                    </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-red">
                    <span class="info-box-icon"><i class="fa fa-slideshare"></i></span>
                    <div class="info-box-content">
                        <a href="{!! route('admin.teachers.index') !!}" class="white"><span
                                    class="info-box-text">@lang('messages.teachers')</span></a>
                        <span class="info-box-number">{!! $countTeacherRepository !!}</span>
                        <div class="progress">
                            <div class="progress-bar" style="width: 70%"></div>
                        </div>
                        <span class="progress-description">
                            @lang('messages.on-total')
                            <strong>{!! $countCourseRepository !!}</strong> @lang('messages.courses').
                        </span>
                    </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->
            </div><!-- /.col -->
        </div>

        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{!! $countCourseRepository !!}</h3>

                        <p>@lang('messages.courses')</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-graduation-cap"></i>
                    </div>
                    <a href="{!! route('admin.courses.index') !!}" class="small-box-footer">@lang('messages.read_more')
                        <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3><a href="#" class="white">{!! $countDocumentComment !!}</a> & <a href="#"
                                                                                             class="white">{!! $countTestComment !!}</a>
                        </h3>

                        <p>@lang('messages.comment_dashboard') @lang('messages.document') & @lang('messages.test') </p>
                    </div>
                    <div class="icon">
                        <i class="fa phpdebugbar-fa-comments-o"></i>
                    </div>
                    <a href="{!! route('admin.comments.index') !!}" class="small-box-footer">@lang('messages.read_more')
                        <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{!! $countUserRepository !!}</h3>

                        <p>@lang('messages.user_dashboard')</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="{!! route('admin.users.index') !!}" class="small-box-footer">@lang('messages.read_more') <i
                                class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3><a href="#" class="white">{{ count($countTransactionRepository) }}</a></h3>

                        <p>@lang('messages.transaction_dashboard')</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-money"></i>
                    </div>
                    <a href="{{ route('admin.transactions.index') }}"
                       class="small-box-footer">@lang('messages.read_more') <i
                                class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        <!-- Custom tabs (Charts with tabs)-->
                        <div class="nav-tabs-custom">
                            <!-- Tabs within a box -->
                            <ul class="nav nav-tabs pull-right">
                                <li class="active"><a href="#revenue-chart"
                                                      data-toggle="tab">@lang('messages.document')</a></li>
                                <li><a href="#sales-chart" data-toggle="tab">@lang('messages.test')</a></li>
                                <li class="pull-left header"><i
                                            class="fa fa-inbox"></i> @lang('messages.comments_lastest')</li>
                            </ul>
                            <div class="tab-content no-padding">
                                <!-- Morris chart - Sales -->
                                <div class="chart tab-pane active" id="revenue-chart">
                                    <div class="box box-solid">
                                        <!-- /.box-header -->
                                        <div class="box-body">
                                            <ul class="products-list product-list-in-box">
                                                @foreach($lastestComments as $lastestComment)
                                                    <li class="item">
                                                        <div>
                                                            <a href="{!! route('admin.comments.show', [$lastestComment->document->id]) !!}"
                                                               class="product-title">{!! $lastestComment->document->name !!}
                                                            </a>
                                                            <span class="product-description">
                          {!! $lastestComment->content !!}
                        </span>
                                                        </div>
                                                    </li>
                                            @endforeach
                                            <!-- /.item -->
                                            </ul>
                                        </div>
                                        <!-- /.box-body -->
                                        <div class="box-footer text-center">
                                            <a href="{!! route('admin.comments.index') !!}"
                                               class="uppercase">@lang('messages.read_all_dashboard')</a>
                                        </div>
                                        <!-- /.box-footer -->
                                    </div>
                                    <!-- /.box -->
                                </div>
                                <div class="chart tab-pane" id="sales-chart">
                                    <div class="box box-solid">
                                        <!-- /.box-header -->
                                        <div class="box-body">
                                            <ul class="products-list product-list-in-box">
                                                @foreach($lastestCommentTests as $lastestCommentTest)
                                                    <li class="item">
                                                        <div>
                                                            <a href="{!! route('admin.commentTests.show', [$lastestCommentTest->test->id]) !!}"
                                                               class="product-title">{!! $lastestCommentTest->test->name !!}</a>
                                                                <span class="product-description">{!! $lastestCommentTest->content !!}</span>
                                                        </div>
                                                    </li>
                                            @endforeach
                                            <!-- /.item -->
                                            </ul>
                                        </div>
                                        <!-- /.box-body -->
                                        <div class="box-footer text-center">
                                            <a href="{!! route('admin.commentTests.index') !!}"
                                               class="uppercase">@lang('messages.read_all_dashboard')</a>
                                        </div>
                                        <!-- /.box-footer -->
                                    </div>
                                    <!-- /.box -->
                                </div>
                            </div>
                        </div>
                        <!-- /.nav-tabs-custom -->
                    </div>
                    <div class="col-md-6">
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <h3 class="box-title">@lang('messages.tutorials_lastest_dashboard')</h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                                class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                                class="fa fa-times"></i></button>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <ul class="products-list product-list-in-box">
                                    @foreach($lastestTutorial as $key => $tutorial)
                                        <li class="item">
                                            <div>
                                                <a href="{!! route('admin.tutorials.show', [$tutorial->id]) !!}"
                                                   class="product-title">{!! $tutorial->title !!}
                                                </a>
                                                <span class="product-description">{!! $tutorial->phone !!} - {!! \App\Helpers\Helper::formatCategories($tutorial->subjects) !!} - {!! \App\Helpers\Helper::formatCategories($tutorial->grades) !!}</span>
                                            </div>
                                        </li>
                                @endforeach
                                <!-- /.item -->
                                </ul>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer text-center">
                                <a href="{!! route('admin.tutorials.index') !!}"
                                   class="uppercase">@lang('messages.read_all_dashboard')</a>
                            </div>
                            <!-- /.box-footer -->
                        </div>
                        <!-- /.box -->
                    </div>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        <!-- USERS LIST -->
                        <div class="box box-warning">
                            <div class="box-header with-border">
                                <h3 class="box-title">@lang('messages.register_user_lastest_dashboard')</h3>

                                <div class="box-tools pull-right">
                                    {{--<span class="label label-danger">8 thành viên mới</span>--}}
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                                class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                                class="fa fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body no-padding">
                                <ul class="users-list clearfix">
                                    @foreach($lastestUsers as $lastestUser)
                                        <li>
                                            @if((!empty($lastestUser->avatar)) && file_exists(public_path($lastestUser->avatar)))
                                                <img src="{!! $lastestUser->avatar !!}" alt="{!! $lastestUser->name !!}"
                                                     width="100px" height="100px">
                                            @else
                                                <img src="/public/uploads/default-avatar.png" alt="{!! $lastestUser->name !!}"
                                                     width="100px" height="100px">
                                            @endif
                                            <a class="users-list-name"
                                               href="{!! route('admin.users.show', [$lastestUser->id]) !!}">{!! $lastestUser->name !!}</a>
                                            {{--<span class="users-list-date">{!! $lastestUser->created_at->format('d-m-y') !!}</span>--}}
                                        </li>
                                    @endforeach
                                </ul>
                                <!-- /.users-list -->
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer text-center">
                                <a href="{!! route('admin.users.index') !!}" class="small-box-footer"><i
                                            class="fa fa-arrow-circle-right"></i> @lang('messages.read_all_dashboard')
                                </a>
                            </div>
                            <!-- /.box-footer -->
                        </div>
                        <!--/.box -->
                    </div>
                    <div class="col-md-6">
                        <div class="box box-danger">
                            <div class="box-header with-border">
                                <h3 class="box-title">@lang('messages.transaction_lastest_dashboard')</h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                                class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                                class="fa fa-times"></i></button>
                                </div>
                            </div>
                            <!-- /.box-header -->

                            <div class="box-body">
                                <ul class="products-list product-list-in-box">
                                    @foreach($lastestTransactions as $key => $value)
                                    <li class="item">
                                        <div class="product-img">
                                            {{--{{ dd($value->user()) }}--}}
                                            @if(!empty($value->user->avatar) && file_exists(public_path($value->user->avatar)))
                                                <img src="{!! $value->user->avatar !!}" alt="{!! $value->user->name !!}" width="250px" height="250px">
                                            @else
                                                <img src="/public/uploads/default-avatar.png" width="300px" height="300px">
                                            @endif
                                        </div>
                                        <div class="product-info">
                                            <a href="{{ route('admin.transactions.show', [$value->id]) }}" class="product-title">{{ $value->user? $value->user->name : ''}}
                                                <span class="label label-warning pull-right">{{ ($value->content == 1 || $value->content == 2)?Helper::format_money($value->money_transfer,true,' KNOW'):'-'.Helper::format_money($value->money_transfer,true,' KNOW') }}</span></a>
                                            <span class="product-description">
                                            {!! Helper::convertTransFields('content',$value->content) !!}
                        </span>
                                        </div>
                                    </li>
                                    @endforeach
                                    <!-- /.item -->
                                </ul>
                            </div>

                            <!-- /.box-body -->
                            <div class="box-footer text-center">
                                <a href="{{ route('admin.transactions.index') }}" class="uppercase">@lang('messages.read_all_dashboard')</a>
                            </div>
                            <!-- /.box-footer -->
                        </div>
                        <!-- /.box -->
                    </div>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>
@endsection
