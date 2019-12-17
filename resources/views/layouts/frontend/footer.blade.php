<footer id="footer">
    <div class="footer-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-6">
                    <h2>@lang('messages.frontend_footer_title')</h2>
                    <p>@lang('messages.frontend_footer_description')</p>
                    <br />
                    <address>
                        <table>
                            <tr>
                                <td width="20"><i class="soap-icon-departure"></i></td>
                                <td>{{ config('system.dia-chi.value') }}</td>
                            </tr>
                            <tr>
                                <td><i class="soap-icon-phone"></i></td>
                                <td>{{ config('system.phone.value') }}</td>
                            </tr>
                            <tr>
                                <td><i class="soap-icon-letter"></i></td>
                                <td>{{ config('system.contact.value') }}</td>
                            </tr>
                        </table>
                    </address>
                    <ul class="social-icons clearfix">
                        <li class="twitter"><a title="{{ config('system.twitter.name') }}" href="{{ config('system.twitter.value') }}" data-toggle="tooltip"><i class="soap-icon-twitter"></i></a></li>
                        <li class="googleplus"><a title="{{ config('system.google-plus.name') }}" href="{{ config('system.google-plus.value') }}" data-toggle="tooltip"><i class="soap-icon-googleplus"></i></a></li>
                        <li class="facebook"><a title="{{ config('system.facebook.name') }}" href="{{ config('system.facebook.value') }}" data-toggle="tooltip"><i class="soap-icon-facebook"></i></a></li>
                        <li class="linkedin"><a title="{{ config('system.linkedin.name') }}" href="{{ config('system.linkedin.value') }}" data-toggle="tooltip"><i class="soap-icon-linkedin"></i></a></li>
                    </ul>
                </div>
                <div class="col-sm-6 col-md-3">
                    <h2>@lang('messages.frontend_footer_link')</h2>
                    <ul class="discover triangle hover row">
                        <li class="col-xs-6 @if($type == 'home') active @endif"><a href="/">@lang('messages.footer_home')</a></li>
                        <li class="col-xs-6 @if($type == 'about') active @endif"><a href="{{ route('pages', 'gioi-thieu') }}">@lang('messages.footer_about')</a></li>
                        <li class="col-xs-6 @if($type == 'documents') active @endif"><a href="{{ route('documents') }}">@lang('messages.footer_documents')</a></li>
                        <li class="col-xs-6 @if($type == 'tests') active @endif"><a href="{{ route('tests') }}">@lang('messages.footer_tests')</a></li>
                        <li class="col-xs-6 @if($type == 'centers') active @endif"><a href="{{ route('centers') }}">@lang('messages.footer_center_teachers')</a></li>
                        <li class="col-xs-6 @if($type == 'tutorials') active @endif"><a href="{{ route('tutorials') }}">@lang('messages.footer_find_teachers')</a></li>
                        <li class="col-xs-6 @if($type == 'news') active @endif"><a href="{{ route('news') }}">@lang('messages.footer_news')</a></li>
                        <li class="col-xs-6 @if($type == 'contacts') active @endif"><a href="{{ route('contacts') }}">@lang('messages.footer_contacts')</a></li>
                    </ul>
                </div>
                <div class="col-sm-6 col-md-3">
                    <h2>@lang('messages.frontend_footer_link')</h2>
                    <ul class="discover triangle hover row">
                        <li class="col-xs-12 @if($type == 'termUse') active @endif"><a href="{{ route('pages', 'dieu-khoan-su-dung') }}">@lang('messages.footer_terms_of_use')</a></li>
                        <li class="col-xs-12 @if($type == 'termSecurity') active @endif"><a href="{{ route('pages', 'dieu-khoan-bao-mat') }}">@lang('messages.footer_terms_of_security')</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom">
        <div class="container-fluid">
            <div class="copyright text-center">
                <a id="back-to-top" href="#" class="animated pull-right" data-animation-type="bounce"><i class="soap-icon-longarrow-up circle"></i></a>
                <div class="info">{{ config('system.copyright-by.value') }} - Design by <a href="http://bloomgoo.vn" target="_blank">BLOOMGOO.VN</a></div>
                <div class="info">{{ config('system.copyright-organization.value') }}</div>
                <div class="info-last">{{ config('system.copyright-license.value') }}</div>
            </div>
        </div>
    </div>
</footer>