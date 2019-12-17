@extends('layouts.frontend')

@section('page_title')
    @include('frontend._partials.breadcrumbs', ['breadcrumbs' => Breadcrumbs::generate('users')])
@endsection

@section('content')
    <div class="container">
        <div id="main">
            @include('flash::message')
            @include('flash::errors')
            <div class="tab-container full-width-style arrow-left dashboard">
             @include('frontend.users.tab_item')
                <div class="tab-content">
                  @include('frontend.users.profile')
                  @include('frontend.users.setting')
                  @include('frontend.users.comment')
                  @include('frontend.users.transaction')
                </div>
            </div>
        </div>
    </div>
@endsection