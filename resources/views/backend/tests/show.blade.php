@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1><i class="fa fa-file-text"></i> @lang('messages.test')</h1>
        {!! Breadcrumbs::render('admin.tests.show', $test) !!}
    </section>
    <div class="content">
        <div class="box box-solid box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-eye"></i> @lang('messages.details')</h3>
                <div class="box-tools pull-right">
                    <!-- Buttons, labels, and many other things can be placed here! -->
                    <!-- Here is a label for example -->
                    <span class="label label-warning">@lang('messages.info')</span>
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        @include('backend.tests.show_fields')
                        <a href="{!! route('admin.tests.index') !!}" class="btn btn-default"><i class="fa fa-mail-reply"></i> @lang('messages.back')</a>
                        <a href="{!! route('admin.tests.edit', [$test->id]) !!}" class='btn btn-default'><i class="glyphicon glyphicon-edit"></i> @lang('messages.edit')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
