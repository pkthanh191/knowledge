@extends('layouts.frontend')

@section('page_title')
    @include('frontend._partials.breadcrumbs', ['breadcrumbs' => Breadcrumbs::generate('tests.show',$test)])
@endsection

@section('content')
    <div class="container flight-detail-page">
        @include('flash::message')

        <div class="row">

            <div class="notice-recharge"></div>
            <div class="sidebar col-md-3">
                <article class="detailed-logo">
                    <figure>
                        <img data-original="{{ $test->image }}" alt="{{ $test->slug }}">
                    </figure>
                    <div class="details">
                        <h2 class="box-title">{{ $test->name }}
                            <small><i class="soap-icon-clock"></i> {{ $test->updated_at }}</small>
                        </h2>
                        <span class="price clearfix">
                                    <small class="pull-left">@lang('messages.frontend-comments')
                                        / @lang('messages.frontend-views')</small>
                                    <span id="comment_view" class="pull-right">{{ $test->comment_counts }}
                                        / {{ $test->view_counts }}</span>
                                </span>

                        {{--#TODO: THỰC HIỆN HIỂN THỊ META DATA--}}
                        <div class="duration">
                            <dl>
                                <dt class="skin-color"
                                    style="min-width: 90px; width: 90px;">@lang('messages.frontend-test-time'):
                                </dt>
                                <dd>{{ $test->duration }} @lang('messages.min')</dd>
                                <br>
                                <dt class="skin-color"
                                    style="min-width: 90px; width: 90px;">@lang('messages.frontend-test-category'):
                                </dt>
                                @foreach($test->categories as $k=>$a)
                                    @if($k!=0)
                                        <dt class="skin-color" style="min-width: 90px; width: 90px;"></dt>
                                    @endif
                                    <dd><a href="{{ route('tests') }}?danh-muc={{ $a->slug }}">{{$a->name}}
                                            ({{ count($a->test) }}) </a></dd>
                                @endforeach
                            </dl>
                        </div>
                        @if (!empty($test->short_description))
                            <div class="description text-justify">{!! $test->short_description !!}</div>
                        @endif
                        {{--<a href="#" class="button green full-width uppercase btn-medium">book flight now</a>--}}
                    </div>
                </article>

                <div class="jquery-accordion-menu white">
                    <div class="jquery-accordion-menu-header uppercase"><i
                                class="fa fa-th"></i> @lang('messages.frontend-test-categories') </div>
                    <ul>
                        @php
                            $parent_id = 0;
                            $last_name = '';
                        @endphp
                        @foreach($categoryTests as $key => $category)
                            @if ($key != 0 && $parent_id != $category->parent_id)
                                @for( $i = 0; $i < substr_count($last_name, '&nbsp;&nbsp;&nbsp;&nbsp') - substr_count($category->name, '&nbsp;&nbsp;&nbsp;&nbsp'); $i++ )
                    </ul>
                    </li>
                    @endfor
                    @endif
                    @php $level = substr_count($category->name, '&nbsp;&nbsp;&nbsp;&nbsp;'); @endphp
                    {{--CÓ CON THÌ LUÔN MỞ--}}
                    @if (count($category->children()) > 0)
                        <li @if($categorySlug == $category->slug && $type == 'tests') class="active" @endif>
                            <a href="{{ route('tests') }}?danh-muc={{ $category->slug }}"><i
                                        class="fa fa-angle-double-right"></i> {{ strlen($category->name)>25+$level*24? substr($category->name, 0, strpos($category->name,' ',25+$level*24)).'...' : $category->name }} ({{ count($category->test) }})</a><span class="submenu-indicator"><i
                                        class="fa fa-plus"></i></span>
                            <ul class="submenu">

                                @php
                                    $parent_id = $category->id
                                @endphp
                                @endif

                                {{--KHÔNG CÓ CON THÌ TỰ ĐÓNG--}}
                                @if (count($category->children()) == 0)
                                    <li @if($categorySlug == $category->slug && $type == 'tests') class="active" @endif>
                                        <a href="{{ route('tests') }}?danh-muc={{ $category->slug }}"><i
                                                    class="fa fa-angle-double-right"></i>{{ strlen($category->name)>30+$level*24? substr($category->name, 0, strpos($category->name,' ',30+$level*24)).'...' : $category->name }} ({{ count($category->test) }})</a>
                                    </li>
                                    @php
                                        $parent_id = $category->parent_id;
                                        $last_name = $category->name;
                                    @endphp
                                @endif
                                @endforeach
                            </ul>
                </div>
            </div>

            <div id="main" class="col-md-6">
                <div class="long-description travelo-box text-justify">
                    <h2>{{ $test->name }}</h2>
                    <hr>
                    {{--@if(!empty($test->file) && file_exists(public_path($test->short_file)))
                        <iframe src="https://docs.google.com/viewer?embedded=true&url={{ url('/').$test->short_file }}"
                                style="width:100%; height:500px;" frameborder="0"></iframe>
                    @endif--}}
                    {{--<iframe src="{{$test->file}}" width="100%" height="500"></iframe>--}}
                    <div class="row">
                        <div class="col-lg-12">
                            @if(!empty($test->file) && file_exists(public_path($test->file)))
                                <a id="minus_money_file" @if(Auth::check()) data-toggle="modal" data-target="#modal-minus-money"
                                   class="button btn-small edit-profile-btn pull-right" @else href="#dang-nhap" class="button btn-small edit-profile-btn pull-right soap-popupbox" @endif
                                   style="background-color: #01b7f2;">@lang('messages.link_download')</a>
                                <div class="modal fade" id="modal-minus-money" style="display: none;">
                                    <form id="confirm_minus_money">
                                        {{ csrf_field() }}
                                        @php $trans_type="download_1" @endphp
                                        @include('_partials.confirm_minus_money')
                                        <input type="hidden" id="slug" name="slug" value="{{explode("/", Request::path())[1]}}">
                                    </form>
                                </div>
                            @endif
                            @if(!empty($test->link_download))
                                <a id="minus_money" @if(Auth::check()) data-toggle="modal" data-target="#modal-minus-money-link"
                                   class="button btn-small edit-profile-btn pull-right" @else href="#dang-nhap" class="button btn-small edit-profile-btn pull-right soap-popupbox" @endif
                                   style="background-color: #01b7f2; margin-right: 15px">@lang('messages.link_download')</a>
                                <div class="modal fade" id="modal-minus-money-link" style="display: none;">
                                    <form id="confirm_minus_money_link">
                                        {{ csrf_field() }}
                                        @php $trans_type="download_2" @endphp
                                        @include('_partials.confirm_minus_money')
                                        <input type="hidden" id="slug" name="slug" value="{{explode("/", Request::path())[1]}}">
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>

                    <p><strong>{!! $test->short_description !!}</strong></p>
                    <p>{!! $test->description !!}</p>
                </div>

                <div class="modal fade" id="modal-minus-money-link" style="display: none;">
                    <form id="confirm_minus_money_link">
                        {{ csrf_field() }}
                        @php $trans_type="download_2" @endphp
                        @include('_partials.confirm_minus_money')
                        <input type="hidden" id="slug" name="slug" value="{{explode("/", Request::path())[1]}}">
                    </form>
                </div>

                @if (!count($testRelatives) == 0)
                    <h2>@lang('messages.frontend-document-relative')</h2>
                    <div class="travelo-box">
                        <div class="suggestions image-carousel style2 relative" data-animation="slide"
                             data-item-width="150" data-item-margin="22">
                            <ul class="slides">
                                @foreach($testRelatives as $key => $testRelative)
                                    <li>
                                        <a href="{{ route('tests.show', $testRelative->slug) }}" class="hover-effect">
                                            <img data-original="{{ $testRelative->image }}" alt="{{ $testRelative->slug }}"
                                                 class="middle-item"/>
                                        </a>
                                        <h5 class="caption">{{ $testRelative->name }}</h5>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <div class="comments-container block">
                    <h2 id="comment_count">{{ $commentCount }} @lang('messages.frontend-comments')</h2>
                    <ul id="comment_list" class="comment-list travelo-box">
                        @if (count($test->comments) == 0)
                            <div id="no-comment">@lang('messages.frontend-no-comments')</div>
                        @else
                            @foreach($test->comments as $key => $comment)
                                @include('frontend._partials.comment_item',['slug'=> $test->slug])
                            @endforeach
                            @if(count($test->comments) > 5 )
                                <hr>
                                <button id="loadMore"
                                        class="btn-large full-width">@lang('messages.frontend_load_more_comment')</button>
                            @endif
                        @endif

                    </ul>
                </div>
                <input type="hidden" id="comment_id" value="0">

                <!-- comment -->
                <div class="post-comment block">
                    <h2 class="reply-title">@lang('messages.frontend-post-comment')</h2>
                    <div class="travelo-box">
                        @if(Auth::check())
                            <form class="comment-form" id="comment_doc">

                                <div class="form-group">
                                    <label>@lang('messages.frontend-comment-message')</label>
                                    <textarea id="content-comment" name="content" rows="6" class="input-text full-width"
                                              placeholder="@lang('messages.frontend-comment-message-placeholder')"></textarea>
                                </div>
                                {{ csrf_field() }}
                                <input type="hidden" id="slug" name="slug" value="{{explode("/", Request::path())[1]}}">
                                <input type="hidden" id="parent_id" name="parent_id" value="0">

                                <button type="submit"  id="post-btn" disabled style="background-color: #f5f5f5;color: black"
                                        class="btn-large full-width">@lang('messages.frontend-comment-submit')</button>
                            </form>
                        @else
                            @lang('messages.frontend_user_to_comment'). <a href="#dang-nhap" class="soap-popupbox" style="color: #01b7f2">@lang('auth.login_sign_in')</a>
                        @endif
                    </div>
                </div>
            @include('_partials.card_item')
            <!-- comment -->

            </div>
            <div class="sidebar col-md-3">
                <div class="tab-container box">
                    <ul class="tabs full-width">
                        <li class="active"><a data-toggle="tab"
                                              href="#recent-posts">@lang('messages.frontend-recent')</a></li>
                        <li><a data-toggle="tab" href="#views-posts">@lang('messages.frontend-views')</a></li>
                        <li><a data-toggle="tab" href="#comments-posts">@lang('messages.frontend-comments')</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="recent-posts" class="tab-pane fade in active">
                            <div class="image-box style14">
                                @foreach($testRecent as $key => $test)
                                    <article class="box">
                                        <figure><a href="{{ route('tests.show', $test->slug) }}"
                                                   title="{{ $test->name }}"><img width="63" height="59"
                                                                                  data-original="{{ $test->image }}"
                                                                                  alt="{{ $test->slug }}"></a></figure>
                                        <div class="details">
                                            <h5 class="box-title"><a
                                                        href="{{ route('tests.show', $test->slug) }}">{{ $test->name }}</a>
                                            </h5>
                                            <label class="price-wrapper"><span class="price-per-unit"><i
                                                            class="fa fa-eye"></i> {{ $test->view_counts }} / <i
                                                            class="fa fa-comments-o"></i> {{ $test->comment_counts }}</span></label>
                                            <p class="font-10"><i class="fa fa-clock-o"></i> {{ $test->created_at }}</p>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </div>
                        <div id="views-posts" class="tab-pane fade">
                            <div class="image-box style14">
                                @foreach($testViews as $key => $test)
                                    <article class="box">
                                        <figure><a href="{{ route('tests.show', $test->slug) }}"
                                                   title="{{ $test->name }}"><img width="63" height="59"
                                                                                  data-original="{{ $test->image }}"
                                                                                  alt="{{ $test->slug }}"></a></figure>
                                        <div class="details">
                                            <h5 class="box-title"><a
                                                        href="{{ route('tests.show', $test->slug) }}">{{ $test->name }}</a>
                                            </h5>
                                            <label class="price-wrapper"><span class="price-per-unit"><i
                                                            class="fa fa-eye"></i> {{ $test->view_counts }} / <i
                                                            class="fa fa-comments-o"></i> {{ $test->comment_counts }}</span></label>
                                            <p class="font-10"><i class="fa fa-clock-o"></i> {{ $test->created_at }}</p>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </div>
                        <div id="comments-posts" class="tab-pane fade">
                            <div class="image-box style14">
                                @foreach($testComments as $key => $test)
                                    <article class="box">
                                        <figure><a href="{{ route('tests.show', $test->slug) }}"
                                                   title="{{ $test->name }}"><img width="63" height="59"
                                                                                  data-original="{{ $test->image }}"
                                                                                  alt="{{ $test->slug }}"></a></figure>
                                        <div class="details">
                                            <h5 class="box-title"><a
                                                        href="{{ route('tests.show', $test->slug) }}">{{ $test->name }}</a>
                                            </h5>
                                            <label class="price-wrapper"><span class="price-per-unit"><i
                                                            class="fa fa-eye"></i> {{ $test->view_counts }} / <i
                                                            class="fa fa-comments-o"></i> {{ $test->comment_counts }}</span></label>
                                            <p class="font-10"><i class="fa fa-clock-o"></i> {{ $test->created_at }}</p>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="travelo-box contact-box">
                    <h2>@lang('messages.menu_contacts')</h2>
                    <address class="contact-details">
                        <span class="contact-phone"><i
                                    class="soap-icon-phone"></i> Hotline: {{ config('system.phone.value') }}</span>
                        <br>
                        <span class="contact-phone"><i
                                    class="soap-icon-letter"></i> {{ config('system.contact.value') }}</span>
                    </address>
                </div>
            </div>
        </div>
    </div>
@endsection



