@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Course Category
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($courseCategory, ['route' => ['admin.courseCategories.update', $courseCategory->id], 'method' => 'patch']) !!}

                        @include('backend.course_categories.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection