@extends('layouts.frontend')

@section('content')
    <section id="content">
        <div class="container">
            <div id="main" style="margin-top: 15px;">
                <div class="row">
                    <div class="col-sm-4 col-md-3">
                        @include('frontend._partials.menu-doc-categories')
                    </div>
                    <div class="col-sm-8 col-md-9" style="background: white; padding: 20px;">
                        @foreach($pages as $page)
                            <h1 class="uppercase">{!! $page->name !!}</h1>
                            <hr>
                            {!! $page->description !!}
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection



