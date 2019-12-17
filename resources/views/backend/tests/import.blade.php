@extends('layouts.app')

@section('content')

    <section class="content-header">
        <h1><i class="fa fa-file-text"></i> @lang('messages.test')</h1>
        {!! Breadcrumbs::render('admin.tests.import') !!}
    </section>

    <div class="content">

        @include('flash::message')
        @include('adminlte-templates::common.errors')
        {!! Form::open(['route' => 'admin.tests.import', 'enctype'=>'multipart/form-data']) !!}
        <div class="row">
            <div class="col-md-12">
                <div class="box box-solid box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-file-excel-o"></i> @lang('messages.import')</h3>
                        <div class="box-tools pull-right">
                            <a href="{{route('admin.tests.formImport')}}"><span class="label label-warning">
                                    <i class="fa fa-download"></i> @lang('messages.download_form')</span>
                            </a>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                {!! Form::label('file', 'File') !!}
                                {!! Form::file('file') !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                {{ Form::button('<i class="fa fa-save"></i> '.Lang::get('messages.save'), array('class'=>'btn btn-primary', 'type'=>'submit')) }}
                                <a href="{!! route('admin.tests.index') !!}" class="btn btn-default"><i class="fa fa-mail-reply"></i> @lang('messages.cancel')</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection