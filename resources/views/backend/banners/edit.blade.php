@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1><i class="fa fa-picture-o"></i> @lang('messages.banners')</h1>
        {!! Breadcrumbs::render('admin.banners.edit',$banner) !!}
    </section>
    <div class="content">
        @include('flash::errors')

        {!! Form::model($banner, ['route' => ['admin.banners.update', $banner->id], 'method' => 'patch','enctype'=>'multipart/form-data']) !!}
        <div class="row">
            <div class="col-md-12">
                <div class="box box-solid box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-edit"></i> @lang('messages.update')</h3>
                        <div class="box-tools pull-right">
                            <span class="label label-warning">@lang('messages.info')</span>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            @include('backend.banners.fields')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection