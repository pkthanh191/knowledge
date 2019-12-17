<li class="header">WWW.KNOWLEDGE.VN</li>

<li class="treeview  {{ Request::is('*dashboard*') ? 'active' : '' }}">
    <a href="{!! route('admin.dashboard.index') !!}">
        <i class="fa fa-dashboard"></i> <span>@lang('messages.dashboard')</span>
    </a>
</li>

<li class="treeview {{ (Request::is('*documents*') || Request::is('*documentMetas*') || Request::is('*categoryDocs*') || Request::is('*categoryDocMetas*')) ? 'active' : '' }}">
    <a href="#">
        <i class="fa fa-file"></i> <span>@lang('messages.document_management')</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ Request::is('*documents/create*') ? 'active' : '' }}">
            <a href="{!! route('admin.documents.create') !!}"><i class="fa fa-plus"></i><span>@lang('messages.create')</span></a>
        </li>
        <li class="{{ (Request::is('*documents*') && !Request::is('*documents/create*')) ? 'active' : '' }}">
            <a href="{!! route('admin.documents.index') !!}"><i class="fa fa-file"></i><span>@lang('messages.document')</span></a>
        </li>
        <li class="{{ Request::is('*categoryDocs*') ? 'active' : '' }}">
            <a href="{!! route('admin.categoryDocs.index') !!}"><i class="fa fa-list-ul"></i><span>@lang('messages.document_category')</span></a>
        </li>
        <li class="{{ Request::is('*documentMetas*') ? 'active' : '' }}">
            <a href="{!! route('admin.documentMetas.index') !!}"><i class="fa fa-cogs"></i><span>@lang('messages.document_meta')</span></a>
        </li>
        <li class="{{ Request::is('*categoryDocMetas*') ? 'active' : '' }}">
            <a href="{!! route('admin.categoryDocMetas.index') !!}"><i class="fa fa-list"></i><span>@lang('messages.document_category_doc_metas')</span></a>
        </li>
    </ul>
</li>

<li class="treeview {{ (Request::is('*tests*') || Request::is('*categoryTests*')) ? 'active' : '' }}">
    <a href="#">
        <i class="fa fa-file-text-o"></i> <span>@lang('messages.test_management')</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ Request::is('*tests/create*') ? 'active' : '' }}">
            <a href="{!! route('admin.tests.create') !!}"><i class="fa fa-plus"></i><span>@lang('messages.create')</span></a>
        </li>

        <li class="{{ (Request::is('*tests*') && !Request::is('*tests/create*')) ? 'active' : '' }}">
            <a href="{!! route('admin.tests.index') !!}"><i class="fa fa-file-text-o"></i><span>@lang('messages.test')</span></a>
        </li>

        <li class="{{ Request::is('*categoryTests*') ? 'active' : '' }}">
            <a href="{!! route('admin.categoryTests.index') !!}"><i class="fa fa-list"></i><span>@lang('messages.category_test')</span></a>
        </li>
    </ul>
</li>

<li class="treeview {{ (Request::is('*centers*') || Request::is('*teachers*') || Request::is('*courses*') || Request::is('*categoryCourses*') || Request::is('*courseOrders*')) ? 'active' : '' }}">
    <a href="#">
        <i class="fa fa-slideshare"></i> <span>@lang('messages.teacher_management')</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ Request::is('*centers/create*') ? 'active' : '' }}">
            <a href="{!! route('admin.centers.create') !!}"><i class="fa fa-plus"></i><span>@lang('messages.center_create')</span></a>
        </li>

        <li class="{{ (Request::is('*centers*') && !Request::is('*centers/create*')) ? 'active' : '' }}">
            <a href="{!! route('admin.centers.index') !!}"><i class="fa fa-bank"></i><span>@lang('messages.center')</span></a>
        </li>

        <li class="{{ Request::is('*teachers/create*') ? 'active' : '' }}">
            <a href="{!! route('admin.teachers.create') !!}"><i class="fa fa-plus"></i><span>@lang('messages.teacher_create')</span></a>
        </li>

        <li class="{{ (Request::is('*teachers*') && !Request::is('*teachers/create*')) ? 'active' : '' }}">
            <a href="{!! route('admin.teachers.index') !!}"><i class="fa fa-slideshare"></i><span>@lang('messages.teachers')</span></a>
        </li>

        <li class="{{ Request::is('*courses/create*') ? 'active' : '' }}">
            <a href="{!! route('admin.courses.create') !!}"><i class="fa fa-plus"></i><span>@lang('messages.course_create')</span></a>
        </li>

        <li class="{{ (Request::is('*courses*') && !Request::is('*courses/create*')) ? 'active' : '' }}">
            <a href="{!! route('admin.courses.index') !!}"><i class="fa fa-graduation-cap"></i><span>@lang('messages.courses')</span></a>
        </li>

        <li class="{{ Request::is('*categoryCourses*') ? 'active' : '' }}">
            <a href="{!! route('admin.categoryCourses.index') !!}"><i class="fa fa-list"></i><span>@lang('messages.course_category')</span></a>
        </li>
    </ul>
</li>

<li class="treeview {{ (Request::is('*subjects*') || Request::is('*grades*') || Request::is('*tutorials*')) ? 'active' : '' }}">
    <a href="#">
        <i class="fa fa-search"></i> <span>@lang('messages.teacher_looking_for_management')</span>
        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ Request::is('*subjects*') ? 'active' : '' }}">
            <a href="{!! route('admin.subjects.index') !!}"><i class="fa fa-book "></i><span>@lang('messages.subjects')</span></a>
        </li>

        <li class="{{ Request::is('*grades*') ? 'active' : '' }}">
            <a href="{!! route('admin.grades.index') !!}"><i class="fa fa-graduation-cap"></i><span>@lang('messages.grades')</span></a>
        </li>

        <li class="{{ Request::is('*tutorials*') ? 'active' : '' }}">
            <a href="{!! route('admin.tutorials.index') !!}"><i class="fa fa-search"></i><span>@lang('messages.tutorials')</span></a>
        </li>
    </ul>
</li>

<li class="treeview {{ (Request::is('*news*') || Request::is('*categoryNews*')) ? 'active' : '' }}">
    <a href="#">
        <i class="fa fa-newspaper-o"></i> <span>@lang('messages.news_management')</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ Request::is('*news/create*') ? 'active' : '' }}">
            <a href="{!! route('admin.news.create') !!}"><i class="fa fa-plus"></i><span>@lang('messages.create')</span></a>
        </li>
        <li class="{{ (Request::is('*news*') && !Request::is('*news/create*')) ? 'active' : '' }}">
            <a href="{!! route('admin.news.index') !!}"><i class="fa fa-newspaper-o"></i><span>@lang('messages.news')</span></a>
        </li>
        <li class="{{ Request::is('*categoryNews*') ? 'active' : '' }}">
            <a href="{!! route('admin.categoryNews.index') !!}"><i class="fa fa-list"></i><span>@lang('messages.category_news')</span></a>
        </li>
    </ul>
</li>

<li class="treeview {{ ((Request::is('*comments*')) || (Request::is('*commentTests*')) || Request::is('*commentNews*')) ? 'active' : '' }}">
    <a href="#">
        <i class="fa fa-commenting-o"></i> <span>@lang('messages.comments_management')</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ Request::is('*comments*') ? 'active' : '' }}">
            <a href="{!! route('admin.comments.index') !!}"><i class="fa fa-commenting-o"></i><span>@lang('messages.comments')</span></a>
        </li>
        <li class="{{ Request::is('*commentTests*') ? 'active' : '' }}">
            <a href="{!! route('admin.commentTests.index') !!}"><i class="fa fa-commenting-o"></i><span>@lang('messages.comment_tests_title')</span></a>
        </li>
        <li class="{{ Request::is('*commentNews*') ? 'active' : '' }}">
            <a href="{!! route('admin.commentNews.index') !!}"><i class="fa fa-commenting-o"></i><span>@lang('messages.comment_news')</span></a>
        </li>
    </ul>
</li>

<li class="treeview  {{ Request::is('*pages*') ? 'active' : '' }}">
    <a href="#">
        <i class="fa fa-file-o"></i> <span>@lang('messages.pages_management')</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
    </a>
    <ul class="treeview-menu">
        {{--<li class="{{ Request::is('*pages/create*') ? 'active' : '' }}"><a href="{{ route('admin.pages.create')}}"><i class="fa fa-plus"></i> @lang('messages.create')</a></li>--}}
        <li class="{{ (Request::is('*pages*') && !Request::is('*pages/create*')) ? 'active' : '' }}"><a href="{{ route('admin.pages.index')}}"><i class="fa fa-file-o"></i> @lang('messages.pages')</a></li>
    </ul>
</li>

<li class="treeview  {{ Request::is('*banners*') ? 'active' : '' }}">
    <a href="#">
        <i class="fa fa-picture-o"></i> <span>@lang('messages.banners_management')</span>
        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ Request::is('*banners/create*') ? 'active' : '' }}"><a href="{{ route('admin.banners.create')}}"><i class="fa fa-plus"></i> @lang('messages.create')</a></li>
        <li class="{{ (Request::is('*banners*') && !Request::is('*banners/create*')) ? 'active' : '' }}"><a href="{{ route('admin.banners.index')}}"><i class="fa fa-picture-o"></i> @lang('messages.banners')</a></li>
    </ul>
</li>

<li class="treeview {{ (Request::is('*transactions*')) ? 'active' : ''}}">
    <a href="#">
        <i class="fa  fa-money"></i> <span>@lang('messages.transactions_management')</span>
        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ Request::is('*transactions*') ? 'active' : '' }}"><a href="{{ route('admin.transactions.index')}}"><i class="fa fa-money"></i> @lang('messages.transactions')</a></li>
    </ul>
</li>

<li class="treeview {{ (Request::is('*user*')) || (Request::is('*configs*')) || Request::is('*coefficients*') ? 'active' : ''}}">
    <a href="#">
        <i class="fa  fa-cogs"></i> <span>@lang('messages.system')</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ Request::is('*users*') ? 'active' : '' }}"><a href="{{ route('admin.users.index')}}"><i class="fa fa-user"></i> @lang('messages.user_management')</a></li>
        <li class="{{ Request::is('*configs*') ? 'active' : '' }}"><a href="{{ route('admin.configs.index')}}"><i class="fa fa-cog"></i> @lang('messages.configs_management')</a></li>
        <li class="{{ Request::is('*coefficients*') ? 'active' : '' }}"><a href="{{ route('admin.coefficients.index')}}"><i class="fa fa-usd"></i> @lang('messages.coefficients_management')</a></li>
    </ul>
</li>

<li class="treeview">
    <a href="#">
        <i class="fa fa-support "></i> <span>@lang('messages.help')</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
    </a>
    <ul class="treeview-menu">
        <li class=""><a href="/user-guide/KNOWLEDGEVN_TailieuHuongdansudung.docx"><i class="fa fa-file-word-o"></i> @lang('messages.help_instruction_document')</a></li>
        <li><a href="#"><i class="fa fa-support"></i> @lang('messages.help_support')</a></li>
    </ul>
</li>
