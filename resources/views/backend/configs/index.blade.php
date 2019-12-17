@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1><i class="fa fa-cog"></i> @lang('messages.configs')</h1>
        {!! Breadcrumbs::render('admin.configs.index') !!}
    </section>
    <section class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="clearfix"></div>
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title"></h3>

                {{--<div class="box-tools">--}}
                    {{--<a class="btn btn-primary" href="{!! route('admin.configs.create') !!}"><i class="fa fa-plus"></i> @lang('messages.create')</a>--}}
                    {{--{{ Form::button('<i class="fa fa-remove"></i> '.Lang::get('messages.delete-all'), array('class'=>'btn btn-danger', 'onclick' => "var r = confirm('".Lang::get('messages.delete_more_confirm')."'); if (r == true) {--}}
{{--$('#items').submit();}")) }}--}}
                {{--</div>--}}

            </div>
            <div class="box-body">
                {!! Form::open(['id' =>'items', 'route' => ['admin.configs.destroy', 'MULTI'], 'method' => 'delete']) !!}
                {!! Form::close() !!}
                @include('backend.configs.table')
            </div>
        </div>
    </section>
@endsection

