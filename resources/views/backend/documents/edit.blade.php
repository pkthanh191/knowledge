@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1><i class="fa fa-file"></i> @lang('messages.document')</h1>
        {!! Breadcrumbs::render('admin.documents.edit', $document) !!}
    </section>
    <div class="content">
        @include('flash::message')
        @include('vendor.flash.errors')
        {!! Form::model($document, ['route' => ['admin.documents.update', $document->id], 'method' => 'patch', 'enctype'=>'multipart/form-data']) !!}
        <div class="row">
            <div class="col-md-9">
                <div class="box box-solid box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-edit"></i> @lang('messages.update')</h3>
                        <div class="box-tools pull-right">
                            <span class="label label-warning">@lang('messages.info')</span>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            @include('backend.documents.fields')
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                @include('shared.categories', ['categories' => $categories, 'selectedCategories' => $selectedCategories])
            </div>
        </div>
    </div>
@endsection