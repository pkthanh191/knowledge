@extends('layouts.app')

@section('content')


    <section class="content-header">
        <h1 class=" fa fa-bank"> @lang('messages.center')</h1>
        {!! Breadcrumbs::render('admin.centers.index') !!}
    </section>

    <section class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="clearfix"></div>
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title"></h3>

                <div class="box-tools">

                    <a class="btn btn-primary"  href="{!! route('admin.centers.create') !!}"><i class="fa fa-plus"></i> @lang('messages.create') </a>
                    {{ Form::button('<i class="fa fa-remove"></i> '.Lang::get('messages.delete-all'), array('class'=>'btn btn-danger', 'onclick' => "var r = confirm('".Lang::get('messages.delete_more_confirm')."'); if (r == true) {
$('#items').submit();}")) }}
                </div>

            </div>

            <div class="box-header with-border">
                <div class="box-tools-search">
                    {!! Form::open(['method'=>'GET','url'=>'admin/centers','role'=>'search'])  !!}
                    <div class="form-inline text-right">
                        {!! Form::text('search[name]',null,['class'=> 'form-control', 'placeholder' => Lang::get('messages.center_search_name_placeholder') ]) !!}
                        {!! Form::text('search[phone]',null,['class'=> 'form-control', 'placeholder' => Lang::get('messages.center_search_phone_placeholder') ]) !!}
                        {!! Form::text('search[email]',null,['class'=> 'form-control', 'placeholder' => Lang::get('messages.center_search_email_placeholder') ]) !!}
                        {!! Form::text('search[address]',null,['class'=> 'form-control', 'placeholder' => Lang::get('messages.center_search_address_placeholder') ]) !!}

                        {{ Form::button('<i class="fa fa-search"></i> '.Lang::get('messages.search'), array('class'=>'btn btn-primary', 'type'=>'submit')) }}
                        <a class="btn btn-warning" href="{!! route('admin.centers.index') !!}"><i class="fa fa-eraser"></i> @lang('messages.reset')</a>
                    </div>
                    {!! Form::close() !!}

                </div>
            </div>

                <div class="box-body">
                    {!! Form::open(['id' =>'items', 'route' => ['admin.centers.destroy', 'MULTI'], 'method' => 'delete']) !!}
                    {!! Form::close() !!}
                    @include('backend.centers.table')
                </div>
        @if($centers->hasPages())
                    <div class="box-footer clearfix">
                        {!! $centers->appends(['search' => Request::get('search')])->render() !!}
                    </div>
                @endif

        </div>

    </section>
    @endsection

