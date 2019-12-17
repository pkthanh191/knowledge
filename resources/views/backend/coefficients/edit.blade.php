@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1><i class="fa fa-usd"></i> @lang('messages.coefficient')</h1>
        {!! Breadcrumbs::render('admin.coefficients.edit',$coefficient) !!}
    </section>
    <div class="content">
        @include('flash::errors')

        {!! Form::model($coefficient, ['route' => ['admin.coefficients.update', $coefficient->id], 'method' => 'patch','enctype'=>'multipart/form-data']) !!}
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
                            @include('backend.coefficients.fields')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection