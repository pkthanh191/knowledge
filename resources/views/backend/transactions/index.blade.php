@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1><i class="fa fa-money"></i> @lang('messages.transactions')</h1>
        {!! Breadcrumbs::render('admin.transactions.index') !!}
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
                    {{--<a class="btn btn-primary" href="{!! route('admin.transactions.create') !!}"><i class="fa fa-plus"></i> @lang('messages.create')</a>--}}
                    {{ Form::button('<i class="fa fa-remove"></i> '.Lang::get('messages.delete-all'), array('class'=>'btn btn-danger', 'onclick' => "var r = confirm('".Lang::get('messages.delete_more_confirm')."'); if (r == true) {
$('#items').submit();}")) }}
                </div>
            </div>
            <div class="box-header with-border">
                <div class="box-tools-search">
                    {!! Form::open(['method' => 'GET','route' => 'admin.transactions.index','role' => 'search']) !!}
                    <div class="form-inline text-right">
                        {{--{!! Form::text('search[content]', null, ['class' => 'form-control', 'placeholder' => Lang::get('messages.transactions_content'), 'maxlength' => '10']) !!}--}}
                        {!! Form::select('search[content]',[0=>__('messages.select_trans_content'),1=>Helper::convertTransFields('content',1),2=>Helper::convertTransFields('content',2),3=>Helper::convertTransFields('content',3),4=>Helper::convertTransFields('content',4),5=>Helper::convertTransFields('content',5),6=>Helper::convertTransFields('content',6),7=>Helper::convertTransFields('content',7)], null, ['class' => 'form-control']) !!}
                        {!! Form::button('<i class="fa fa-search"></i> '.Lang::get('messages.search'), ['class' => 'btn btn-primary','type'=>'submit']) !!}
                        <a class="btn btn-warning" href="{!! route('admin.transactions.index') !!}"><i
                                    class="fa fa-eraser"></i> @lang('messages.reset')</a>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="box-body">
                {!! Form::open(['id' =>'items', 'route' => ['admin.transactions.destroy', 'MULTI'], 'method' => 'delete']) !!}
                {!! Form::close() !!}
                @include('backend.transactions.table')
            </div>
            @if($transactions->hasPages())
                <div class="box-footer clearfix">
                    {!! $transactions->appends(['search' => Request::get('search')])->render() !!}
                </div><!-- box-footer -->
            @endif
        </div>
    </section>
@endsection

