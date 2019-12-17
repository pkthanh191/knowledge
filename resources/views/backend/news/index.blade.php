@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1><i class="fa fa-newspaper-o"></i> @lang('messages.news')</h1>
        {!! Breadcrumbs::render('admin.news.index') !!}
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title"></h3>

                <div class="box-tools">
                    <a class="btn btn-primary" href="{!! route('admin.news.create') !!}"><i class="fa fa-plus"></i> @lang('messages.create')</a>
                    {{ Form::button('<i class="fa fa-remove"></i> '.Lang::get('messages.delete-all'), array('class'=>'btn btn-danger', 'onclick' => "var r = confirm('".Lang::get('messages.delete_more_confirm')."'); if (r == true) {
$('#items').submit();}")) }}
                </div>

            </div>
            <div class="box-header with-border">
                <div class="box-tools-search">
                    {!! Form::open(['method' => 'GET','route' => 'admin.news.index','role' => 'search']) !!}
                    <div class="form-inline text-right">
                        {!! Form::text('search[name]', null, ['class' => 'form-control', 'placeholder' => Lang::get('messages.news_placeholder_search_name'), 'maxLength'=>'50']) !!}
                        {!! Form::select('search[category]', $categories, null, ['class' => 'form-control']) !!}
                        {{ Form::button('<i class="fa fa-search"></i> '.Lang::get('messages.search'), array('class'=>'btn btn-primary', 'type'=>'submit')) }}
                        <a class="btn btn-warning" href="{!! route('admin.news.index') !!}"><i class="fa fa-eraser"></i> @lang('messages.reset')</a>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="box-body">
                {!! Form::open(['id' =>'items', 'route' => ['admin.news.destroy', 'MULTI'], 'method' => 'delete']) !!}
                {!! Form::close() !!}
                @include('backend.news.table')
            </div>
            @if($news->hasPages())
                <div class="box-footer">
                    {!! $news->appends(['search' => Request::get('search')])->render() !!}
                </div>
            @endif
        </div>

    </div>
@endsection