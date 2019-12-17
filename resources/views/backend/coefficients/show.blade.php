@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Coefficient
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('backend.coefficients.show_fields')
                    <button class="btn btn-default" onclick="history.go(-1);"><i class="fa fa-mail-reply"></i> @lang('messages.back') </button>
                </div>
            </div>
        </div>
    </div>
@endsection
