@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1><i class="fa fa-list"></i> @lang('messages.category_doc_metas')</h1>
        {!! Breadcrumbs::render('admin.categoryDocMetas.index') !!}
    </section>
    <section class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"></h3>
                    <div class="box-tools">
                        <a class="btn btn-primary" href="{!! route('admin.categoryDocMetas.create') !!}"><i class="fa fa-plus"></i> @lang('messages.create')</a>
                        {{ Form::button('<i class="fa fa-remove"></i> '.Lang::get('messages.delete-all'), array('class'=>'btn btn-danger', 'onclick' => "var r = confirm('".Lang::get('messages.delete_more_confirm')."'); if (r == true) {
$('#items').submit();}")) }}
                    </div>
                </div>
                <div class="box-header with-border">
                    <div class="box-tools-search">
                        {!! Form::open(['method'=>'GET','url'=>'/admin/categoryDocMetas','role'=>'search'])  !!}
                        <div class="form-inline text-right">
                            {!! Form::text('search',null,['class'=> 'form-control', 'placeholder' => Lang::get('messages.category_search_name_placeholder') ]) !!}
                            {{ Form::button('<i class="fa fa-search"></i> '.Lang::get('messages.search'), array('class'=>'btn btn-primary', 'type'=>'submit')) }}
                            <a class="btn btn-warning" href="{!! route('admin.categoryDocMetas.index') !!}"><i class="fa fa-eraser"></i> @lang('messages.reset')</a>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
                <div class="box-body">
                    {!! Form::open(['id' =>'items', 'route' => ['admin.categoryDocMetas.destroy', 'MULTI'], 'method' => 'delete']) !!}
                    {!! Form::close() !!}
                    @include('backend.category_doc_metas.table')
                </div>
                @if($categoryDocMetas->hasPages())
                    <div class="box-footer">
                        {!! $categoryDocMetas->appends(['search' => Request::get('search')])->render() !!}
                    </div>
                @endif
            </div>
    </section>
@endsection
