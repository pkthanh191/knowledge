@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            <i class="fa fa-book"></i> @lang('messages.subjects')
        </h1>
        {!! Breadcrumbs::render('admin.subjects.create') !!}
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        {!! Form::open(['route' => 'admin.subjects.store','enctype'=>'multipart/form-data']) !!}
        <div class="row">
            <div class="col-md-12">
                <div class="box box-solid box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-plus"></i> @lang('messages.create')</h3>
                        <div class="box-tools pull-right">
                            <span class="label label-warning">@lang('messages.info')</span>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            @include('backend.subjects.fields')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection

