@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1><i class="fa fa-usd"></i> @lang('messages.coefficients')</h1>
        {!! Breadcrumbs::render('admin.coefficients.index') !!}
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
                    <a class="btn btn-primary" href="{!! route('admin.coefficients.create') !!}"><i class="fa fa-plus"></i> @lang('messages.create')</a>
                    {{ Form::button('<i class="fa fa-remove"></i> '.Lang::get('messages.delete-all'), array('class'=>'btn btn-danger', 'onclick' => "var r = confirm('".Lang::get('messages.delete_more_confirm')."'); if (r == true) {
$('#items').submit();}")) }}
                </div>

            </div>
            <div class="box-body">
                {!! Form::open(['id' =>'items', 'route' => ['admin.banners.destroy', 'MULTI'], 'method' => 'delete']) !!}
                {!! Form::close() !!}
                @include('backend.coefficients.table')
            </div>
            @if($coefficients->hasPages())
                <div class="box-footer clearfix">
                    {!! $coefficients->appends(['search' => Request::get('search')])->render() !!}
                </div><!-- box-footer -->
            @endif
        </div>
    </section>
@endsection

