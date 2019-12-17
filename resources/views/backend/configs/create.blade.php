@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            <i class="fa fa-cog"></i> @lang('messages.users')
        </h1>
        {!! Breadcrumbs::render('admin.configs.create') !!}
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        {!! Form::open(['route' => 'admin.configs.store']) !!}
        <div class="row">
            <div class="col-md-12">
                <div class="box box-solid box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-plus"></i> @lang('messages.create')</h3>
                        <div class="box-tools pull-right">
                            <!-- Buttons, labels, and many other things can be placed here! -->
                            <!-- Here is a label for example -->
                            <span class="label label-warning">@lang('messages.info')</span>
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                        @include('backend.configs.fields')

                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
