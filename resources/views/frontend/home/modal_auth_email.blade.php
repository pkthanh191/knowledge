<div class="modal fade in" id="modalAuth" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <form action="{{ route('auth-email') }}" method="POST" id="auth-mail-form">
                {{ csrf_field() }}
                <input type="hidden" name="name" value="{{ session('user')->name }}">
                <input type="hidden" name="avatar" value="{{ session('user')->avatar }}">
                <input type="hidden" name="social_id" value="{{ session('user')->id }}">
                <div class="modal-header">
                    {{--<button type="button" class="close" data-dismiss="modal" style="width: 20px; height: 20px">&times;</button>--}}
                    <div class="text-center">
                        <h3 style="text-transform:uppercase; margin: 10px 0px 10px 0px">@lang('auth.auth_email')</h3>
                    </div>
                </div>
                <div class="modal-body" style="padding-bottom: 0px">
                    <div class="form-group">
                        <label>@lang('messages.user_email') <span class="required">(*)</span></label>
                        <input type="email" name="email" class="form-control" value="{{ session('user')->email }}" required placeholder="@lang('messages.user_email_placeholder')" @if(session('user')->email) readonly="readonly" @endif>
                        <div id="auth-error-email"></div>
                    </div>
                    <div class="form-group">
                        <label>@lang('messages.user_phone') <span class="required">(*)</span></label>
                        <input type="text" name="phone" class="form-control" required placeholder="@lang('messages.user_phone_placeholder')">
                        <div id="auth-error-phone"></div>
                    </div>
                    <div class="form-group">
                        <label>@lang('messages.user_password') <span class="required">(*)</span></label>
                        <input type="password" name="password" class="form-control" required placeholder="@lang('auth.register_password')">
                        <div id="auth-error-password"></div>
                    </div>
                    <div class="form-group">
                        <label>@lang('auth.register_confirm_password') <span class="required">(*)</span></label>
                        <input type="password" name="password_confirmation" class="form-control" required placeholder="@lang('auth.register_confirm_password')">
                    </div>
                </div>
                <div class="text-center" id="auth-notice"></div>
                <div class="modal-footer" style="border-top: none; padding-top: 0px;">
                    <button onclick="return modalAuthSubmit()">@lang('messages.save')</button>
                </div>
            </form>
        </div>

    </div>
</div>