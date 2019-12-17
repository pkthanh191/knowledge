@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1><i class="fa fa-cog"></i> @lang('messages.configs')</h1>
        {!! Breadcrumbs::render('admin.configs.show',$key) !!}
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
                        @include('backend.configs.show_fields')
                        <br>
                        <a href="{!! route('admin.configs.index') !!}" class="btn btn-default"><i class="fa fa-mail-reply"></i> @lang('messages.back')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


