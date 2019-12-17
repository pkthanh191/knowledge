<ul class="menu">
    <li class="menu-item-has-children  @if($type == 'home') active @endif">
        <a href="/">@lang('messages.menu_home')</a>
    </li>
    <li class="menu-item-has-children  @if($type == 'about') active @endif">
        <a href="{{ route('pages', 'gioi-thieu') }}">@lang('messages.menu_about')</a>
    </li>
    <li class="menu-item-has-children  @if($type == 'documents') active @endif">
        <a href="{{ route('documents') }}">@lang('messages.menu_documents')</a>
    </li>
    <li class="menu-item-has-children  @if($type == 'tests') active @endif">
        <a href="{{ route('tests') }}">@lang('messages.menu_tests')</a>
    </li>
    <li class="menu-item-has-children  @if($type == 'centers' || $type == 'teachers' || $type == 'courses') active @endif">
        <a href="{{ route('centers') }}">@lang('messages.menu_center')</a>
    </li>
    <li class="menu-item-has-children @if($type == 'tutorials') active @endif">
        <a href="{{ route('tutorials') }}">@lang('messages.tutorials')</a>
    </li>
    <li class="menu-item-has-children @if($type == 'forums') active @endif">
        <a href="{{ route('home.forums') }}">@lang('messages.forums')</a>
    </li>
    {{--<li class="menu-item-has-children">
        <a href="http://shop.knowledge.vn" target="_blank">SHOP</a>
    </li>--}}
    <li class="menu-item-has-children  @if($type == 'news') active @endif">
        <a href="{{ route('news') }}">@lang('messages.menu_news')</a>
    </li>
    <li class="menu-item-has-children  @if($type == 'contacts') active @endif">
        <a href="{{ route('contacts') }}">@lang('messages.menu_contacts')</a>
    </li>
</ul>