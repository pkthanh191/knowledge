@extends('layouts.frontend')

@section('page_title')
    @include('frontend._partials.breadcrumbs', ['breadcrumbs' => Breadcrumbs::generate('news',$currentCategory)])
@endsection

@section('content')
    <div class="container">
        <div id="main">
            <div class="row">
                <div class="col-sm-4 col-md-3">
                    <div class="travelo-box">
                        <h5 class="box-title">@lang('messages.search')</h5>
                        <form action="{{ route('news') }}" method="GET">
                            <div class="with-icon full-width">
                                <input type="text" name="search[name]" value="{{ $search }}" class="input-text full-width" placeholder="@lang('messages.frontend-search-placeholder')">
                                <button type="submit" class="icon green-bg white-color"><i class="soap-icon-search"></i></button>
                            </div>
                        </form>
                    </div>

                    @include('frontend._partials.menu-news-categories')
                </div>
                <div class="col-sm-8 col-md-6">
                    @include('frontend.news.list')
                </div>

                <div class="col-sm-4 col-md-3">
                    @include('frontend._partials.news-categories')
                </div>
            </div>
        </div>
    </div>
@endsection



