@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Document Meta Value
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($documentMetaValue, ['route' => ['admin.documentMetaValues.update', $documentMetaValue->id], 'method' => 'patch']) !!}

                        @include('backend.document_meta_values.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection