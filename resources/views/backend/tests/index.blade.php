@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1><i class="fa fa-file-text"></i> @lang('messages.test') </h1>
        {!! Breadcrumbs::render('admin.tests.index') !!}
    </section>
    <section class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title"></h3>
                <div class="box-tools">
                    <a class="btn btn-primary" href="{!! route('admin.tests.create') !!}"><i class="fa fa-plus"></i> @lang('messages.create')</a>
                    <a class="btn btn-success" href="{{ route('admin.tests.import') }}"><i class="fa fa-file-excel-o"></i> @lang('messages.import') </a>
                    <form style="display: inline" action="{{ route('admin.tests.export') }}" method="POST">
                        {{ csrf_field() }}
                        @if(isset($_GET['search']))
                            @foreach($tests_export as $test)
                                <input type="hidden" name="searched[]" value="{{ $test->id }}">
                            @endforeach
                        @endif
                        <button type="submit" class="btn btn-info"><i class="fa fa-file-excel-o"></i> @lang('messages.export') </button>
                    </form>
{{--                    <a class="btn btn-info" href="{{ route('admin.tests.export') }}"><i class="fa fa-file-excel-o"></i> @lang('messages.export') </a>--}}
                    {{ Form::button('<i class="fa fa-remove"></i> '.Lang::get('messages.delete-all'), array('class'=>'btn btn-danger', 'onclick' => "var r = confirm('".Lang::get('messages.delete_more_confirm')."'); if (r == true) {
$('#items').submit();}")) }}
                </div>
            </div>
            <div class="box-header with-border">
                <div class="box-tools-search">
                    {!! Form::open(['method'=>'GET','url'=>'/admin/tests','role'=>'search'])  !!}
                    <div class="form-inline text-right">
                        {!! Form::text('search[name]',null,['class'=> 'form-control', 'placeholder' => Lang::get('messages.test_placeholder_search_name') ]) !!}
                        {!! Form::select('search[category]', $categories, null, ['class' => 'form-control']) !!}
                        {{--{!! Form::text('search[category]', null, ['class' => 'form-control', 'placeholder' => Lang::get('messages.test_placeholder_search_category')]) !!}--}}
                        {{ Form::button('<i class="fa fa-search"></i> '.Lang::get('messages.search'), array('class'=>'btn btn-primary', 'type'=>'submit')) }}
                        <a class="btn btn-warning" href="{!! route('admin.tests.index') !!}"><i class="fa fa-eraser"></i> @lang('messages.reset')</a>
                    </div>
                    {!! Form::close() !!}
                    {{--<form style="border: 4px solid #a1a1a1;margin-top: 15px;padding: 10px;" action="{{ route('admin.tests.importExcel')  }}" class="form-horizontal" method="post" enctype="multipart/form-data">--}}
                        {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                        {{--<input type="file" name="import_file" />--}}
                        {{--<button class="btn btn-primary">Import File</button>--}}
                    {{--</form>--}}
                </div>

            </div>
            {!! Form::open(['id' =>'items', 'route' => ['admin.tests.destroy', 'MULTI'], 'method' => 'delete']) !!}
            {!! Form::close() !!}
            @include('backend.tests.table')
            <div class="box-footer clearfix">
                {!! $tests->appends(['search' => Request::get('search')])->render() !!}
            </div>
        </div>
    </section>
@endsection

