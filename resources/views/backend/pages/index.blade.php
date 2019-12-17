@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1><i class="fa fa-file-o"></i> @lang('messages.pages_management')</h1>
        {!! Breadcrumbs::render('admin.pages.index') !!}
    </section>
    <section class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-solid">
            {{--<div class="box-header with-border">--}}
                {{--<h3 class="box-title"></h3>--}}

                {{--<div class="box-tools">--}}
                    {{--<a class="btn btn-primary" href="{!! route('admin.pages.create') !!}"><i class="fa fa-plus"></i> @lang('messages.create')</a>--}}
                    {{--{{ Form::button('<i class="fa fa-remove"></i> '.Lang::get('messages.delete-all'), array('class'=>'btn btn-danger', 'onclick' => "var r = confirm('".Lang::get('messages.delete_more_confirm')."'); if (r == true) {--}}
{{--$('#items').submit();}")) }}--}}
                {{--</div>--}}

            {{--</div>--}}
            <div class="box-header with-border">
                <h3 class="box-title"></h3>
                {{--<div class="box-tools">--}}
                    {{--{!! Form::open(['method' => 'GET','route' => 'admin.pages.index','role' => 'search']) !!}--}}
                    {{--<div class="form-group form-inline">--}}
                        {{--{!! Form::text('search[name]', null, ['class' => 'form-control', 'placeholder' => Lang::get('messages.static_pages_placeholder_search_name')]) !!}--}}
                        {{--{!! Form::text('search[description]', null, ['class' => 'form-control', 'placeholder' => Lang::get('messages.static_pages_placeholder_search_description')]) !!}--}}
                        {{--{{ Form::button('<i class="fa fa-search"></i> '.Lang::get('messages.search'), array('class'=>'btn btn-primary', 'type'=>'submit')) }}--}}
                        {{--<a class="btn btn-warning" href="{!! route('admin.pages.index') !!}"><i class="fa fa-eraser"></i> @lang('messages.reset')</a>--}}
                    {{--</div>--}}
                    {{--{!! Form::close() !!}--}}
                {{--</div>--}}
            </div>
            <div class="box-body">
                {{--{!! Form::open(['id' =>'items', 'route' => ['admin.pages.destroy', 'MULTI'], 'method' => 'delete']) !!}--}}
                {{--{!! Form::close() !!}--}}
                @include('backend.pages.table')
            {{--</div>--}}
            @if($pages->hasPages())
                <div class="box-footer">
                    {!! $pages->appends(['search' => Request::get('search')])->render() !!}
                </div>
            @endif
        </div>

    </div>
    </section>
@endsection

