@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1><i class="fa fa-list"></i> @lang('messages.category_news')</h1>
        {!! Breadcrumbs::render('admin.categoryNews.edit', $categoryNews) !!}
   </section>
   <div class="content">
       @include('flash::errors')

       {!! Form::model($categoryNews, ['route' => ['admin.categoryNews.update', $categoryNews->id], 'method' => 'patch']) !!}
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
                           @include('backend.category_news.fields')
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>
@endsection