@extends('layouts.frontend')

@section('content')
    <div class="container">
        <div id="main" style="margin-top: 15px;">
            <div class="row">
                @if(session('modal_auth'))
                    @include('frontend.home.modal_auth_email');
                @endif
                <div class="col-sm-4 col-md-3">
                    @include('frontend._partials.menu-doc-categories')
                </div>
                <div class="col-sm-8 col-md-9">

                    {{--@include('frontend.home.banner')--}}

                    @if (!count($documents) == 0)
                        @include('frontend.home.slide_document')
                    @endif

                    @if (!count($tests) == 0)
                        @include('frontend.home.slide_test')
                    @endif

                    @if (!count($centers) == 0)
                        @include('frontend.home.slide_center')
                    @endif

                    @if (!count($teachers) == 0)
                        @include('frontend.home.slide_teacher')
                    @endif

                    <input type="hidden" id="comment_id" value="0">
                    <div class="modal fade" id="modal-minus-money-link" style="display: none;">
                        <form id="confirm_minus_money_link">
                            {{ csrf_field() }}
                            @php $trans_type="download_2" @endphp
                            @include('_partials.confirm_minus_money')
                            <input type="hidden" id="slug" name="slug" value="{{explode("/", Request::path())[0]}}">
                        </form>
                    </div>

                    {{--@if (!count($courses) == 0)--}}
                        {{--<h2>@lang('messages.frontend-home-course')</h2>--}}
                        {{--@include('frontend.home.slide_course')--}}
                    {{--@endif--}}
                </div>
            </div>
        </div>
    </div>
    <div id="modal-load-more" class="modal fade" role="dialog">
        <div class="modal-dialog" style="top: 45%; left:10%">
            <div class="text-center"><img width="60px" src="{{ url('loading.gif') }}"></div>
        </div>
    </div>
@endsection



