@extends('layouts.frontend')

@section('page_title')
    @include('frontend._partials.breadcrumbs', ['breadcrumbs' => Breadcrumbs::generate('teachers')])
@endsection

@section('content')
    <div class="container">
        <div id="main">
            <div class="row">
                <div class="col-sm-4 col-md-3">
                    @include('frontend._partials.menu-center-categories')
                </div>
                <div class="col-sm-8 col-md-9">
                    <div class="sort-by-section clearfix">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <form action="{{ route('teachers') }}" method="GET">
                                        <input type="hidden" name="mode" value="{{ $mode }}"/>
                                        <div class="form-group with-icon full-width search-toolbar" style="margin-left: 10px;">
                                            <input type="text" name="search[name]" value="{{ $search }}" class="input-text full-width" placeholder="@lang('messages.frontend-search-placeholder')">
                                            <button type="submit" class="icon green-bg white-color"><i class="soap-icon-search"></i></button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <ul class="swap-tiles clearfix block-sm">
                                    <li class="swap-list  @if ($mode == "list") active @endif">
                                        <a id="list-mode"><i class="soap-icon-list"></i></a>
                                    </li>
                                    <li class="swap-block @if ($mode == "grid" || $mode == null) active @endif">
                                        <a id="grid-mode"><i class="soap-icon-block"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    @if(count($teachers) == 0)
                        <br><p>@lang('messages.not-found')</p>
                    @else
                        <div class="grid-mode" @if ($mode != "grid" && $mode != null) style="display: none;" @endif>
                            @include('frontend.teachers.grid')
                        </div>

                        <div class="list-mode" @if ($mode != "list") style="display: none;" @endif>
                            @include('frontend.teachers.list')
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection



