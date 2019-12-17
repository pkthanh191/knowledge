@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Test Category
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($testCategory, ['route' => ['admin.testCategories.update', $testCategory->id], 'method' => 'patch']) !!}

                        @include('backend.test_categories.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection