@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Course Order
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($courseOrder, ['route' => ['admin.courseOrders.update', $courseOrder->id], 'method' => 'patch']) !!}

                        @include('backend.course_orders.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection