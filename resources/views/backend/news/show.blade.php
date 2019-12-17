@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1><i class="fa fa-newspaper-o"></i> @lang('messages.news')</h1>
        {!! Breadcrumbs::render('admin.news.show', $news) !!}
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
                        @include('backend.news.show_fields')
                        <button class="btn btn-default" onclick="history.go(-1);"><i class="fa fa-mail-reply"></i>@lang('messages.back') </button>
                        <a href="{!! route('admin.news.edit', [$news->id]) !!}" class='btn btn-default'><i class="glyphicon glyphicon-edit"></i> @lang('messages.edit')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
