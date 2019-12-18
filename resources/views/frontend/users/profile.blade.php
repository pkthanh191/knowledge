<div id="profile" class="tab-pane fade in active">
    <div class="view-profile">
        <article class="image-box style2 box innerstyle personal-details">
            <figure>
                @if(!empty($user->avatar) && (file_exists(public_path($user->avatar))))
                    <img src="{!! $user->avatar !!}" alt="{!! $user->name !!}" width="270" height="263">
                @else
                    <img src="/public/uploads/default-avatar.png" alt="{!! $user->name !!}" width="270" height="263">
                @endif
            </figure>
            <div class="details">
                <button class="button btn-small pull-right btn-recharge" data-toggle="modal" data-target="#modal-recharge-money">@lang('messages.frontend-recharge-money')</button>
                {{--<input class="button btn-small pull-right btn-recharge" type="button" id="btn_deposit" value="@lang('messages.frontend-recharge')" />
                <button class="button btn-small pull-right btn-recharge" data-toggle="modal" data-target="#modal-recharge">@lang('messages.frontend-recharge-card')</button>--}}

                <a href="#" class="button btn-small pull-right edit-profile-btn">@lang('messages.edit')</a>
                <h2 class="box-title fullname">{{ $user->name }}</h2>
                <dl class="term-description">
                    <dt>@lang('messages.user_email'):</dt><dd>{{ $user->email }}</dd>
                    <dt>@lang('messages.user_sex'):</dt><dd>{{ Helper::convertSex($user->sex) }}</dd>
                    <dt>@lang('messages.user_age'):</dt><dd>{{ $user->age }}</dd>
                    <dt>@lang('messages.user_phone'):</dt><dd>{{ $user->phone }}</dd>
                    <dt>@lang('messages.user_address'):</dt><dd>{{ $user->address }}</dd>
                    <dt>@lang('messages.user_account_balance'):</dt><dd id="account_balance">{{ Helper::format_money($user->account_balance, true, ' KNOW') }}</dd>
                </dl>
                @if($link_checkout)
                    <script type="text/javascript" src="{{ asset('public/frontend/js/nganluong.apps.mcflow.js') }}"></script>
                    <script language="javascript">
                        var mc_flow = new NGANLUONG.apps.MCFlow({trigger:'btn_deposit',url:'{{ isset($link_checkout)? $link_checkout : "" }}}'});
                    </script>
                @endif
            </div>
            @include('_partials.card_item')
            @include('_partials.recharge_money')
            <hr>
        </article>
    </div>
    <div class="edit-profile">
        <form class="edit-profile-form" action="{{ route('users.update') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <h2>@lang('messages.frontend_detail_user')</h2>
            <div class="col-sm-9 no-padding no-float">
                <div class="form-group col-sm-6">
                    {!! Form::label('avatar', __('messages.user_avatar')) !!}
                    @if(isset($user))
                        @if(!empty($user->avatar) && (file_exists(public_path($user->avatar)) || (filter_var($user->avatar, FILTER_VALIDATE_URL) && getimagesize($user->avatar))))
                            <img src="{!! $user->avatar !!}" alt="{!! $user->name !!}" height="200">
                        @else
                            <img src="/public/uploads/default-avatar.png" alt="{!! $user->name !!}" height="200">
                            <br>
                        @endif
                        {{--<div><img src="{!! $user->avatar !!}" style="height: 200px"></div>--}}
                    @endif
                    {!! Form::file('avatar') !!}
                </div>
                <div class="clearfix"></div>
                <div class="row form-group">
                    <div class="col-sms-6 col-sm-6">
                        <label>@lang('messages.user_name') <span class="required">(*)</span></label>
                        <input type="text" name="name" class="form-control" required placeholder="" value="{{ $user->name }}">
                    </div>
                    <div class="col-sms-6 col-sm-6">
                        <label>@lang('messages.user_address')</label>
                        <input type="text" name="address" class="form-control" placeholder="" value="{{ $user->address }}">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sms-6 col-sm-6">
                        <label>@lang('messages.user_phone') <span class="required">(*)</span></label>
                        <input type="text" name="phone" class="form-control" required placeholder="" value="{{ $user->phone }}">
                    </div>
                    <div class="col-sms-6 col-sm-3">
                        <label>@lang('messages.user_age')</label>
                        <input type="number" name="age" class="form-control" placeholder="" value="{{ $user->age }}" oninput="validity.valid||(value='');">
                    </div>
                    <div class="col-sms-6 col-sm-3">
                        <label>@lang('messages.user_sex')</label>

                        <select class="form-control" name="sex">
                            <option value="1" @if($user->sex == 1) selected @endif>{{ Helper::convertSex(1) }}</option>
                            <option value="2" @if($user->sex == 2) selected @endif>{{ Helper::convertSex(2) }}</option>
                            <option value="3" @if($user->sex == 3) selected @endif>{{ Helper::convertSex(3) }}</option>
                        </select>

                    </div>
                </div>
                <div class="from-group">
                    <button type="submit" class="button col-sms-2 col-sm-2">@lang('messages.save')</button>
                    <button type="button" onclick="jQuery('#form-back').submit()" class="button col-sms-2 col-sm-2" style="margin-left: 20px; background-color: #D2CCDE">@lang('messages.cancel')</button>
                </div>

            </div>
        </form>
        <form action="{{ route('users') }}" method="get" id="form-back"></form>
    </div>
</div>