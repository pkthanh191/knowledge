<ul class="mobile-topnav container">
    @if(Auth::check())
        <li><a>{{ Helper::format_money(Auth::user()->account_balance, true, ' KNOW') }}</a></li>
        <li><a href="{{route('users')}}">Nạp tiền</a></li>
        @if(Auth::user()->group_id == 1)
            <li><a href="{{route('admin.dashboard.index')}}">@lang('messages.frontend_dashboard_page')</a></li>
        @endif
        <li><a href="{{route('users')}}">@lang('messages.frontend_profile')</a></li>
        <li>
            <form action="{{route('logout')}}" id="logout-form" method="post"
                  style="display: none;">{{ csrf_field() }}</form>
            <a onclick="event.preventDefault(); document.getElementById('logout-form').submit();" href="/">@lang('auth.sign_out')</a>
        </li>
    @else
        <li><a href="#dang-ky" class="soap-popupbox button yellow btn-small"
               style="height: 30px;"><i class="soap-icon-card"></i> @lang('auth.login_dont_have_account')</a>
        </li>
        <li><a href="#dang-nhap" class="soap-popupbox"><i class="fa fa-login"></i>@lang('auth.login_sign_in')
            </a></li>
        <li><a href="#dang-ky" class="soap-popupbox"><i class="fa fa-login"></i> @lang('auth.register')</a>
        </li>
    @endif
</ul>