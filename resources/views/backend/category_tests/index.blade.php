@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1><i class="fa fa-list"></i> @lang('messages.category_test')</h1>
        {!! Breadcrumbs::render('admin.categoryTests.index') !!}
    </section>
    <section class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title"></h3>
                <div class="box-tools">
                    <a class="btn btn-primary" href="{!! route('admin.categoryTests.create') !!}"><i class="fa fa-plus"></i> @lang('messages.create')</a>
                {{ Form::button('<i class="fa fa-remove"></i> '.Lang::get('messages.delete-all'), array('class'=>'btn btn-danger', 'onclick' => "var r = confirm('".Lang::get('messages.delete_more_confirm')."'); if (r == true) {
$('#items').submit();}")) }}
                <!-- Button trigger modal -->
                    {{--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong">--}}
                        {{--Launch demo modal--}}
                    {{--</button>--}}
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    dau xanh
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-header with-border">
                <div class="box-tools-search">
                    {!! Form::open(['method'=>'GET','url'=>'/admin/categoryTests','role'=>'search'])  !!}
                    <div class="form-inline text-right">
                        {!! Form::text('search',null,['class'=> 'form-control', 'placeholder' => Lang::get('messages.category_search_name_placeholder') ]) !!}
                        {{ Form::button('<i class="fa fa-search"></i> '.Lang::get('messages.search'), array('class'=>'btn btn-primary', 'type'=>'submit')) }}
                        <a class="btn btn-warning" href="{!! route('admin.categoryTests.index') !!}"><i class="fa fa-eraser"></i> @lang('messages.reset')</a>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="box-body">
                {!! Form::open(['id' =>'items', 'route' => ['admin.categoryTests.destroy', 'MULTI'], 'method' => 'delete']) !!}
                {!! Form::close() !!}
                @include('backend.category_tests.table')
            </div>
            {{--@if($categoryTests->hasPages())--}}
            {{--<div class="box-footer">--}}
            {{--{!! $categoryTests->appends(['search' => Request::get('search')])->render() !!}--}}
            {{--</div>--}}
            {{--@endif--}}
        </div>
    </section>
@endsection


