@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Subject Tutorial
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($subjectTutorial, ['route' => ['admin.subjectTutorials.update', $subjectTutorial->id], 'method' => 'patch']) !!}

                        @include('backend.subject_tutorials.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection