<div class="image-style style1 tutorial-box large-block">
    <h3 class="box-title">{{$tutorial->title}}</h3>
    <hr class="margin-10">
    <div class="row salary">
        <div class="date col-xs-12">
            <div class="row">
                <div class="col-md-5"><span class="skin-color"><i class="fa fa-money yellow-color"></i> @lang('messages.frontend_tutorial_salary')</span></div>
                <div class="col-md-7"><span class="" style="color: red; font-size: 14px;">{!! isset($tutorial->salary) ? $tutorial->salary : __('messages.frontend_tutorial_unknown') !!}</span></div>
            </div>
        </div>
    </div>
    <hr class="margin-10">
    <div class="row time">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-md-5"><i class="fa fa-briefcase yellow-color"></i> <span class="skin-color">@lang('messages.frontend_tutorial_grade')</span></div>
                <div class="col-md-7">{{Helper::formatCategories($tutorial->grades)}}</div>
            </div>
        </div>

        <div class="col-xs-12">
            <div class="row">
                <div class="col-md-5"><i class="fa fa-book yellow-color"></i> <span class="skin-color">@lang('messages.frontend_tutorial_subject')</span></div>
                <div class="col-md-6">{{Helper::formatCategories($tutorial->subjects)}}</div>
            </div>
        </div>

        <div class="col-xs-12">
            <div class="row">
                <div class="col-md-5">
                    <i class="fa fa-clock-o yellow-color"></i>
                    <span class="skin-color">@lang('messages.frontend_tutorial_period')</span>
                </div>
                <div class="col-md-7">{!! isset($tutorial->period) ? $tutorial->period : __('messages.frontend_tutorial_unknown')!!}</div>
            </div>
        </div>

        <div class="col-xs-12">
            <div class="row">
                <div class="col-md-5">
                    <i class="fa fa-bullseye yellow-color"></i>
                    <span class="skin-color">@lang('messages.frontend_tutorial_frequency')</span>
                </div>
                <div class="col-md-7">{!! isset($tutorial->frequency) ? $tutorial->frequency : __('messages.frontend_tutorial_unknown')!!}</div>
            </div>
        </div>

        <div class="col-xs-12">
            <div class="row">
                <div class="col-md-5">
                    <i class="fa fa-map-marker yellow-color"></i>
                    <span class="skin-color">@lang('messages.frontend_tutorial_place')</span>
                </div>
                <div class="col-md-7">{!! $tutorial->district->name.' / '.$tutorial->district->city->name !!}</div>
            </div>
        </div>

    </div>
    <hr class="margin-10">
    <div class="take-off">
        <span class="skin-color">@lang('messages.frontend_tutorial_requirement')</span>: {!! isset($tutorial->requirement) ? $tutorial->requirement : __('messages.frontend_tutorial_unknown')!!}
    </div>
    <hr class="margin-10">
    <div id="show_more_tutorial_{{ $tutorial->id }}" class="row time"></div>
    <div class="action text-center">

        @if(Auth::check())
        <a id="{{ $tutorial->id }}" data-toggle="modal" data-target="#modal_show_detail" class="button btn-small minus_money">@lang('messages.frontend_tutorial_detail')</a>
        @else
            Bạn cần đăng nhập để xem chi tiết. <a href="#dang-nhap" class="soap-popupbox" style="color: #01b7f2">@lang('auth.login_sign_in')</a>
        @endif
    </div>
    <div class="clearfix"></div>
</div>