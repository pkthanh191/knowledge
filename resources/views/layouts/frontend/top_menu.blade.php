<div class="topnav hidden-xs">
    <div class="container">
        <ul class="quick-menu pull-left">
            <li><a><i class="fa fa-mobile"></i> {{ config('system.phone.value') }} - <i
                            class="fa fa-envelope-o"></i> {{ config('system.contact.value') }}</a>
            </li>
        </ul>
        @if(Auth::check())
            <div class="profile pull-right">
                <ul class="quick-menu pull-right dropdown">
                    <li><a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            @if(!empty(Auth::user()->avatar) && (file_exists(public_path(Auth::user()->avatar))))
                                <img data-original="/public/{!! Auth::user()->avatar !!}" alt="{!! Auth::user()->name !!}"
                                     width="25px" height="25px" style="border-radius: 50%;width: 25px;height: 25px; ">
                            @else
                                <img data-original="/public/uploads/default-avatar.png" alt="{!! Auth::user()->name !!}"
                                     width="25px" height="25px" style="border-radius: 50%;width: 25px;height: 25px; ">
                            @endif
                            {!! Auth::user()->name !!}
                            <span id="is_down" class="glyphicon" >
                                    <i class=" glyphicon-chevron-down"></i>
                                </span>
                        </a>
                        <ul class="dropdown-menu">
                            @if(Auth::user()->group_id == 1)
                                <li class="info"><a href="{{route('admin.dashboard.index')}}">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <i class="fa fa-tachometer"></i>
                                            </div>
                                            <div class="col-md-9">
                                                @lang('messages.frontend_dashboard_page')
                                            </div>
                                        </div>
                                    </a>
                                    <hr>
                                </li>
                            @endif
                            <li class="info"><a href="{{route('users')}}">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <div class="col-md-9">
                                            @lang('messages.frontend_profile')
                                        </div>
                                    </div>
                                </a>
                                <hr>
                            </li>
                            <li  class="info">
                                <form action="{{route('logout')}}" id="logout-form" method="post"
                                      style="display: none;">{{ csrf_field() }}</form>
                                <a onclick="event.preventDefault(); document.getElementById('logout-form').submit();" href="/">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <i class="fa fa-sign-out"></i>
                                        </div>
                                        <div class="col-md-9">
                                            @lang('auth.sign_out')
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

            <ul class="quick-menu pull-right">
                <li><a class="soap-popupbox"><i class="soap-icon-card"></i> {{ Helper::format_money(Auth::user()->account_balance, true, ' KNOW') }}</a>
                </li>
                <li></li>
                <li><a href="{{route('users')}}" class="button btn-small" style="height: 30px;">Nạp tiền</a>
                </li>
            </ul>
        @else
            <ul class="quick-menu pull-right">
                <li><a href="#dang-ky" class="soap-popupbox button yellow btn-small"
                       style="height: 30px;"><i class="soap-icon-card"></i> @lang('auth.login_dont_have_account')</a>
                </li>
                <li><a href="#dang-nhap" class="soap-popupbox"><i class="fa fa-login"></i>@lang('auth.login_sign_in')
                    </a></li>
                <li><a href="#dang-ky" class="soap-popupbox"><i class="fa fa-login"></i> @lang('auth.register')</a>
                </li>
            </ul>
        @endif
    </div>
</div>