@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1><i class="fa fa-picture-o"></i> @lang('messages.banners')</h1>
        {!! Breadcrumbs::render('admin.banners.show',$banner) !!}
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
                        @include('backend.banners.show_fields')
                        <br>
                        <button class="btn btn-default" onclick="history.go(-1);"><i class="fa fa-mail-reply"></i>@lang('messages.back') </button>
                        <a href="{!! route('admin.banners.edit', [$banner->id]) !!}" class='btn btn-default'><i class="glyphicon glyphicon-edit"></i> @lang('messages.edit')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
