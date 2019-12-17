@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1><i class="fa fa-file"></i> @lang('messages.document')</h1>
        {!! Breadcrumbs::render('admin.documents.index') !!}
    </section>

    <section class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title"></h3>

                <div class="box-tools">
                    <a class="btn btn-primary" href="{!! route('admin.documents.create') !!}"><i class="fa fa-plus"></i> @lang('messages.create')</a>
                    <a class="btn btn-success" href="{{ route('admin.documents.import') }}"><i class="fa fa-file-excel-o"></i> @lang('messages.import') </a>
                    <form style="display: inline" action="{{ route('admin.documents.export') }}" method="POST">
                        {{ csrf_field() }}
                        @if(isset($_GET['search']))
                            @foreach($documents_export as $document)
                                <input type="hidden" name="searched[]" value="{{ $document->id }}">
                            @endforeach
                        @endif
                        <button type="submit" class="btn btn-info"><i class="fa fa-file-excel-o"></i> @lang('messages.export') </button>
                    </form>
                    {{ Form::button('<i class="fa fa-remove"></i> '.Lang::get('messages.delete-all'), array('class'=>'btn btn-danger', 'onclick' => "var r = confirm('".Lang::get('messages.delete_more_confirm')."'); if (r == true) {
$('#items').submit();}")) }}
                </div>
            </div>

            <div class="box-header with-border">
                <div class="box-tools-search">
                    {!! Form::open(['method'=>'GET', 'route' => 'admin.documents.index', 'role'=>'search'])  !!}
                    <div class="form-inline text-right">
                        {!! Form::text('search[name]', null, ['class'=> 'form-control', 'placeholder' => Lang::get('messages.document_search_name_placeholder') ]) !!}
                        {!! Form::select('search[category]', $categories, null, ['class'=> 'form-control']) !!}
                        {{ Form::button('<i class="fa fa-search"></i> '.Lang::get('messages.search'), array('class'=>'btn btn-primary', 'type'=>'submit')) }}
                        <a class="btn btn-warning" href="{!! route('admin.documents.index') !!}"><i class="fa fa-eraser"></i> @lang('messages.reset')</a>
                    </div>
                    {!! Form::close() !!}
                </div>

            </div>

            <div class="box-body">
                {!! Form::open(['id' =>'items', 'route' => ['admin.documents.destroy', 'MULTI'], 'method' => 'delete']) !!}
                {!! Form::close() !!}
                @include('backend.documents.table')
            </div>

            @if($documents->hasPages())
                <div class="box-footer">
                    {!! $documents->appends(['search' => Request::get('search')])->render() !!}
                </div>
            @endif
        </div>
    </section>

@endsection

