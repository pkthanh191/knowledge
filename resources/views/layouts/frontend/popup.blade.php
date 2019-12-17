<div class="popup-wrapper"><i class="fa fa-spinner fa-spin spinner" style="display: none;"></i>
    <div class="col-xs-12 col-sm-9 popup-content">
        <div id="dang-nhap" class="travelo-login-box travelo-box" style="display: none;">
            <div class="text-center"><h1>@lang('auth.login_sign_in')</h1></div>
            <div class="login-social">
                {{--<a href="{{ route('login-facebook') }}" class="button login-facebook"><i
                            class="soap-icon-facebook"></i>@lang('auth.login_with_facebook')</a>--}}
                <a href="{{ route('login-google') }}" class="button login-googleplus"><i
                            class="soap-icon-googleplus"></i>@lang('auth.login_with_google')</a>
            </div>
            <div class="seperator"><label>HOẶC</label></div>
            <!-- /.login-logo -->
            <div class="login-box-body">

                <form id="login-form" method="POST" action="{{ route('login-user') }}">
                    {!! csrf_field() !!}

                    <div class="form-group has-feedback">
                        <input type="text" id="email_or_phone" class="form-control" name="email_or_phone" required
                               value="{{ old('email') }}"
                               placeholder=" @lang('auth.login_email_or_phone')">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>

                    <div class="form-group has-feedback">
                        <input id="password" type="password" class="form-control" required
                               placeholder=" @lang('auth.login_password')"
                               name="password">
                        <a href="javascript:;" id="show-hide-password" class="form-control-feedback" style="pointer-events: visible;"><i class="glyphicon glyphicon-lock"></i></a>

                    </div>
                    <div class="row">
                        <div class="col-xs-8">
                            <div class="checkbox icheck">
                                <label>
                                    <input type="checkbox" name="remember"> @lang('auth.login_remember_me')
                                </label>
                            </div>
                        </div>
                    </div>

                    <div id="notice-login" style="margin: 1px;"></div>

                    <button type="submit" id="button-login" class="full-width btn-medium">@lang('auth.login_sign_in')</button>
                </form>
                <br>
                <p><a href="#quen-mat-khau" class="soap-popupbox">@lang('auth.login_i_forgot_my_password')</a></p>
                <div class="seperator"></div>
            </div>
            <!-- /.login-box-body -->
            <p>@lang('auth.login_dont_have_account') <a href="#dang-ky"
                                                        class="goto-signup soap-popupbox">@lang('auth.register')</a></p>
        </div>
        <div id="dang-ky" class="travelo-signup-box travelo-box" style="display: none;">

            <div class="text-center"><h1>@lang('auth.register_create_new_account')</h1></div>
            <div class="login-social">
                {{--<a href="{{ route('login-facebook') }}" class="button login-facebook"><i
                            class="soap-icon-facebook"></i>@lang('auth.sign_up_with_facebook')</a>--}}
                <a href="{{ route('login-google') }}" class="button login-googleplus"><i
                            class="soap-icon-googleplus"></i>@lang('auth.sign_up_with_google')</a>
            </div>

            <div class="seperator"><label>HOẶC</label></div>
            <div class="register-box-body">
                <form id="register-form" method="post" action="{{ route('register') }}">

                    {!! csrf_field() !!}

                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                               placeholder="@lang('auth.register_name')">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        <div id="reg-notice-name"></div>
                    </div>

                    <div class="form-group has-feedback">
                        <input type="email" class="form-control" name="email" required
                               placeholder="@lang('auth.register_email')">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        <div id="reg-notice-email"></div>
                    </div>

                    {{--Phone field--}}
                    <div class="form-group has-feedback">
                        <input type="phone" class="form-control" name="phone" value="{{ old('phone') }}" required
                               placeholder="@lang('auth.register_phone')"
                               pattern="^(09)[0-9]{8}$|^(03)[0-9]{8}$|^(05)[0-9]{8}$|^(07)[0-9]{8}$|^(08)[0-9]{8}$">
                        <span class="glyphicon glyphicon-phone-alt form-control-feedback"></span>
                        <div id="reg-notice-phone"></div>
                    </div>

                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" name="password" required
                               placeholder="@lang('auth.register_password')">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        <div id="reg-notice-password"></div>
                    </div>

                    <div class="form-group has-feedback">
                        <input type="password" name="password_confirmation" class="form-control" required
                               placeholder="@lang('auth.register_confirm_password')">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="checkbox icheck">
                                <label>
                                    <input type="checkbox" id="agree"> @lang('auth.register_i_agree_to')
                                    <a href="trang/dieu-khoan-su-dung" target="_blank"><u style="color: deepskyblue">@lang('auth.terms')</u></a>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div id="notice-register"></div>
                    <button type="submit" class="full-width btn-medium">@lang('auth.register_create_new_account')</button>
                </form>
                <div class="seperator"></div>

                <p>@lang('auth.register_i_already_have_a_membership') <a href="#dang-nhap"
                                                                         class="goto-login soap-popupbox">@lang('auth.login_sign_in')</a>
                </p>
            </div>
        </div>
        <div id="quen-mat-khau" class="travelo-forgot-pass-box travelo-box">
            <div class="text-center"><h1>@lang('auth.r_reset_your_password')</h1></div>
            <div class="seperator"></div>
            <div class="login-box-body">

                <form id="forgot-pass-form" method="post" action="{{route('forgot-password')}}">
                    {!! csrf_field() !!}

                    <div class="form-group has-feedback ">
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                               placeholder="@lang('auth.r_email')" required>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div id="notice-forgot-password"></div>
                    <button type="submit" class="full-width btn-medium">@lang('auth.email_send_password_reset_link')</button>

                </form>
                <div class="seperator"></div>

            </div>
            <br>
            <div class="pull-left">
                <p><a href="#dang-nhap" class="goto-login soap-popupbox">@lang('auth.login_sign_in')</a></p>
            </div>
            <div class="pull-right">
                <p><a href="#dang-ky" class="goto-login soap-popupbox">@lang('auth.register')</a></p>
            </div>
            <br>
        </div>
    </div>
</div>
</div>