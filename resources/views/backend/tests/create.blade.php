@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1><i class="fa fa-file-text "></i> @lang('messages.test')</h1>
        {!! Breadcrumbs::render('admin.tests.create') !!}
    </section>
    <div class="content">
        @include('flash::message')
        @include('flash::errors')

        {!! Form::open(['route' => 'admin.tests.store','enctype'=>'multipart/form-data']) !!}
        <div class="row">
            <div class="col-md-9">
                <div class="box box-solid box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-plus"></i> @lang('messages.create')</h3>
                        <div class="box-tools pull-right">
                            <span class="label label-warning">@lang('messages.info')</span>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            @include('backend.tests.fields')
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                @include('shared.categories', ['categories' => $categories, 'selectedCategories' => $selectedCategories])
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
