@extends('layouts.frontend')

@section('page_title')
    @include('frontend._partials.breadcrumbs', ['breadcrumbs' => Breadcrumbs::generate('tutorials')])
@endsection

@section('content')
    <div class="container">
        <div id="main">
            @include('flash::message')
            <div class="notice-recharge" style="margin-left: 0px; margin-right: 0px;"></div>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="sort-by-section clearfix box">
                        <div class="row">
                            {!! Form::open(['method' => 'GET', 'route' => 'tutorials', 'role' => 'search']) !!}
                            <div class="form-group col-xs-12 col-sm-6 col-md-4 post-toolbar">
                                <label for="id_label_single">
                                    {!! Form::select('search[city_code]', $cities, null, ['class' => 'form-control', 'id'=>'city_id']) !!}
                                </label>
                            </div>
                            <div class="form-group col-xs-12 col-sm-6 col-md-4 post-toolbar">
                                <label for="id_label_single">
                                    {!! Form::select('search[district]', $districts, null, ['class' => 'form-control', 'id'=>'district_id']) !!}
                                </label>
                            </div>
                            <div class="form-group col-xs-12 col-sm-6 col-md-4 post-toolbar">
                                <label for="id_label_single">
                                    {!! Form::select('search[grade]', $grades, null, ['class' => 'form-control']) !!}
                                </label>
                            </div>
                            <div class="form-group col-xs-12 col-sm-6 col-md-4 post-toolbar">
                                <label for="id_label_single">
                                    {!! Form::select('search[subject]', $subjects, null, ['class' => 'form-control']) !!}
                                </label>
                            </div>
                            <div class="form-group col-xs-12 col-sm-6 col-md-4 fixheight post-toolbar">
                                <button type="submit" class="full-width icon-check animated" data-animation-type="bounce" data-animation-duration="1">@lang('messages.search')</button>
                            </div>
                            {!! Form::close() !!}

                            <div class="form-group col-xs-12 col-sm-6 col-md-4 fixheight post-toolbar">
                                <form action="{!! route('tutorials.register') !!}" method="get">
                                    <button class="full-width soap-icon-doc-plus animated uppercase" data-animation-type="bounce" data-animation-duration="1" style="background-color: #01b7f2;"> @lang('messages.frontend_tutorial_post')</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @if($first == true)
                        @include('frontend.tutorials.grid')
                    @else
                        @include('frontend.tutorials.grid_search')
                    @endif

                    @include('_partials.card_item')

                    <div class="modal fade" id="modal_show_detail" style="display: none;">
                        <form id="confirm_minus_money_detail_tutorial">
                            {{ csrf_field() }}
                            @include('_partials.confirm_show_detail')
                            <input type="hidden" class="tutorial_id" name="tutorial_id" value="">
                        </form>
                    </div>
                    <div class="modal fade" id="modal_minus_money" style="display: none;">
                        <form id="confirm_send_mail">
                            {{ csrf_field() }}
                            @php $trans_type="detail_tutorial" @endphp
                            @include('_partials.confirm_minus_money')
                            <input type="hidden" class="tutorial_id" name="tutorial_id" value="">
                        </form>
                    </div>
                    <div class="modal fade" id="modal_get_info" style="display: none;">
                        <form id="get_info">
                            {{ csrf_field() }}
                            @include('_partials.get_info')
                            <input type="hidden" class="tutorial_id" name="tutorial_id" value="">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection