@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1><i class="fa fa-search"></i> @lang('messages.tutorials')</h1>
        {!! Breadcrumbs::render('admin.tutorials.index') !!}
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
                    <a class="btn btn-primary" href="{!! route('admin.tutorials.create') !!}"><i class="fa fa-plus"></i> @lang('messages.create')</a>
                    @if($checkActive == false)<a class="btn bg-olive" id="toggle" value="tutorials_activeAll"><i class="fa fa-check"></i> @lang('messages.tutorials_activeAll')</a>
                    @else <a class='btn btn-warning' id='toggle' value="tutorials_deActiveAll"><i class='fa fa-close'></i> @lang('messages.tutorials_deActiveAll')</a>@endif
                    @if($checkConfirm == false)<a class="btn btn-green" id="toggleConfirm" value="tutorials_comfirmAll"><i class="fa fa-check"></i> @lang('messages.tutorials_comfirmAll')</a>
                    @else <a class='btn btn-yellow' id='toggleConfirm' value="tutorials_unConfirmAll"><i class='fa fa-close'></i> @lang('messages.tutorials_unConfirmAll')</a>@endif
                    {{ Form::button('<i class="fa fa-remove"></i> '.Lang::get('messages.delete-all'), array('class'=>'btn btn-danger', 'onclick' => "var r = confirm('".Lang::get('messages.delete_more_confirm')."'); if (r == true) { $('#items').submit();}")) }}
                </div>

            </div>
            <div class="box-header with-border">
                <div class="box-tools-search">
                    {!! Form::open(['method' => 'GET','route' => 'admin.tutorials.index','role' => 'search']) !!}
                    <div class="form-inline text-right">
                        {!! Form::text('search[title_or_phone]', null, ['class' => 'form-control', 'placeholder' => Lang::get('messages.tutorials_placeholder_title')]) !!}
{{--                        {!! Form::text('search[phone]', null, ['class' => 'form-control', 'placeholder' => Lang::get('messages.tutorials_placeholder_phone')]) !!}--}}
                        {!! Form::select('search[subject]', $subjects,null, ['class' => 'form-control']) !!}
                        {!! Form::select('search[grade]', $grades,null, ['class' => 'form-control']) !!}
                        {!! Form::select('search[city_code]', $cities,null, ['class' => 'form-control','id'=>'city_id']) !!}
                        {!! Form::select('search[district_id]',$districts, null, ['class' => 'form-control', 'id'=>'district_id']) !!}
                        {!! Form::button('<i class="fa fa-search"></i> '.Lang::get('messages.search'), ['class' => 'btn btn-primary','style'=>'margin: 5px;','type'=>'submit']) !!}
                        <a class="btn btn-warning" href="{!! route('admin.tutorials.index') !!}"><i class="fa fa-eraser"></i> @lang('messages.reset')</a>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="box-body">
                {!! Form::open(['id' =>'items', 'route' => ['admin.tutorials.destroy', 'MULTI'], 'method' => 'delete']) !!}
                {!! Form::close() !!}
                @include('backend.tutorials.table')
            </div>
            @if($tutorials->hasPages())
                <div class="box-footer clearfix">
                    {!! $tutorials->appends(['search' => Request::get('search')])->render() !!}
                </div>
            @endif
        </div>
    </section>
@endsection

