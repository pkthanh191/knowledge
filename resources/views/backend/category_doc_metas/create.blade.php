@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1><i class="fa fa-list"></i> @lang('messages.category_doc_metas')</h1>
        {!! Breadcrumbs::render('admin.categoryDocMetas.create') !!}
    </section>
    <div class="content">
        @include('vendor.flash.errors')
        {!! Form::open(['route' => 'admin.categoryDocMetas.store']) !!}
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
                            @include('backend.category_doc_metas.fields')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
