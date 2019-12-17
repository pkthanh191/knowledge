@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1><i class="fa fa-list-ul"></i> @lang('messages.category_docs')</h1>
        {!! Breadcrumbs::render('admin.categoryDocs.show', $categoryDoc) !!}
    </section>
    <div class="content">
        <div class="box box-solid box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-eye"></i> @lang('messages.details')</h3>
                <div class="box-tools pull-right">
                    <span class="label label-warning">@lang('messages.info')</span>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        @include('backend.category_docs.show_fields')
                        <a href="{!! route('admin.categoryDocs.index') !!}" class="btn btn-default"><i class="fa fa-mail-reply"></i> @lang('messages.back')</a>
                        <a href="{!! route('admin.categoryDocs.edit', [$categoryDoc->id]) !!}" class='btn btn-default'><i class="glyphicon glyphicon-edit"></i> @lang('messages.edit')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
