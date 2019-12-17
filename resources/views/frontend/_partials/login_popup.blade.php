<div id="travelo-login" class="travelo-login-box travelo-box">
    <div class="login-social">
        {{--<a href="#" class="button login-facebook"><i class="soap-icon-facebook"></i>@lang('messages.frontend_login_facebook')</a>--}}
        <a href="#" class="button login-googleplus"><i class="soap-icon-googleplus"></i>@lang('messages.frontend_login_googleplus')</a>
    </div>
    <div class="seperator"><label>@lang('messages.frontend_or')</label></div>
    <form>
        <div class="form-group">
            <input type="text" class="input-text full-width" placeholder="@lang('messages.frontend_placeholder_email')">
        </div>
        <div class="form-group">
            <input type="password" class="input-text full-width" placeholder="@lang('messages.frontend_placeholder_password')">
        </div>
        <div class="form-group">
            <a href="#" class="forgot-password pull-right">@lang('messages.frontend_forget_password')</a>
            <div class="checkbox checkbox-inline">
                <label><input type="checkbox">@lang('messages.frontend_remember_me')</label>
            </div>
        </div>
    </form>
    <div class="seperator"></div>
    <p>@lang('messages.frontend_dont_have_acc') <a href="#travelo-signup" class="goto-signup soap-popupbox">@lang('messages.frontend_signup')</a></p>
</div>