@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1><i class="fa fa-newspaper-o"></i> @lang('messages.news')</h1>
        {!! Breadcrumbs::render('admin.news.edit', $news) !!}
   </section>
   <div class="content">
       @include('flash::message')
       @include('flash::errors')
       {!! Form::model($news, ['route' => ['admin.news.update', $news->id], 'method' => 'patch','enctype'=>'multipart/form-data']) !!}
       <div class="row">
           <div class="col-md-9">
               <div class="box box-solid box-primary">
                   <div class="box-header with-border">
                       <h3 class="box-title"><i class="fa fa-edit"></i> @lang('messages.update')</h3>
                       <div class="box-tools pull-right">
                           <span class="label label-warning">@lang('messages.info')</span>
                       </div>
                   </div>
                   <div class="box-body">
                       <div class="row">
                           @include('backend.news.fields')
                       </div>
                   </div>
               </div>
           </div>

           <div class="col-md-3">
               @include('shared.categories', ['categories' => $categories, 'selectedCategories' => $selectedCategories])
           </div>
       </div>
   </div>
@endsection