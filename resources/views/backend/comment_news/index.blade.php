@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1><i class="fa fa-commenting-o"></i> @lang('messages.comment_news')</h1>
        {!! Breadcrumbs::render('admin.commentNews.index') !!}
    </section>
    <section class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title"></h3>

                <div class="box-tools">
                    <a class="btn btn-primary" href="{!! route('admin.commentNews.create') !!}"><i class="fa fa-plus"></i> @lang('messages.create')</a>
                    {{--{{ Form::button('<i class="fa fa-remove"></i> '.Lang::get('messages.delete-all'), array('class'=>'btn btn-danger', 'onclick' => "var r = confirm('".Lang::get('messages.delete_more_confirm')."'); if (r == true) {--}}
{{--$('#items').submit();}")) }}--}}
                </div>

            </div>
            <div class="box-header with-border">
                <div class="box-tools-search">
                    {!! Form::open(['method'=>'GET','url'=>'/admin/commentNews','role'=>'search'])  !!}
                    <div class="form-inline text-right">
                        {!! Form::select('search[category]', $categories, null, ['class'=> 'form-control', 'id'=> 'categoryNews']) !!}
                        {!! Form::select('search[news_id]',$newsSearch, null, ['class' => 'form-control', 'id'=> 'news']) !!}
                        {{ Form::button('<i class="fa fa-search"></i> '.Lang::get('messages.search'), array('class'=>'btn btn-primary', 'type'=>'submit')) }}
                        <a class="btn btn-warning" href="{!! route('admin.commentNews.index') !!}"><i class="fa fa-eraser"></i> @lang('messages.reset')</a>
                    </div>
                    {!! Form::close() !!}
                </div>

            </div>
            <div class="box-body">
                {!! Form::open(['id' =>'items', 'route' => ['admin.commentNews.destroy', 'MULTI'], 'method' => 'delete']) !!}
                {!! Form::close() !!}
                @include('backend.comment_news.table')
            </div>
            {{--@if($documents->hasPages())--}}
            {{--<div class="box-footer">--}}
            {{--{!! $courses->appends(['search' => Request::get('search')])->render() !!}--}}
            {{--</div>--}}
            {{--@endif--}}
        </div>
    </section>
@endsection