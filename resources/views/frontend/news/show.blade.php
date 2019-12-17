@extends('layouts.frontend')

@section('page_title')
    @include('frontend._partials.breadcrumbs', ['breadcrumbs' => Breadcrumbs::generate('news.show',$newsIndex)])
@endsection

@section('content')
    <div class="container flight-detail-page">
        <div class="row">
            <div class="sidebar col-md-3">
                <article class="detailed-logo">
                    <figure>
                        <img data-original="{{ $newsIndex->image }}" alt="{{ $newsIndex->slug }}">
                    </figure>
                    <div class="details">
                        <h2 class="box-title">{{ $newsIndex->name }}
                            <small><i class="soap-icon-clock"></i> {{ $newsIndex->updated_at }}</small>
                        </h2>
                        @if (!empty($news->short_description))
                            <div class="description text-justify">{!! $newsIndex->short_description !!}</div>
                        @endif
                        <div class="duration">
                            <dl>
                                <dt class="skin-color"
                                    style="min-width: 90px; width: 90px;">@lang('messages.categories'):
                                </dt>
                                @foreach($newsIndex->categories as $k=>$a)
                                    @if($k!=0)
                                        <dt class="skin-color" style="min-width: 90px; width: 90px;"></dt>
                                    @endif
                                    <dd><a href="{{ route('news') }}?danh-muc={{ $a->slug }}">{{$a->name}}
                                            ({{ count($a->news) }}) </a></dd>
                                @endforeach

                            </dl>
                        </div>
                    </div>
                </article>
                @include('frontend._partials.menu-news-categories')
            </div>
            <div id="main" class="col-md-6">
                <div id="flight-features news" class="tab-container">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="flight-details">
                            <div class="long-description">
                                <h2>{{ $newsIndex->name }}</h2>
                                <hr>
                                <div class="text-justify"><strong>{!! $newsIndex->short_description !!}</strong></div>
                                <div class="text-justify">{!! $newsIndex->description !!}</div>
                            </div>
                        </div>
                    </div>
                </div>

                @if (!count($newsRelatives) == 0)
                    <h2 style="margin-top: 15px;">@lang('messages.frontend-news-relative')({{ count($newsRelatives) }})</h2>
                    <div class="travelo-box">
                        <div class="suggestions image-carousel style2 relative" data-animation="slide"
                             data-item-width="150" data-item-margin="22">
                            <ul class="slides">
                                @foreach($newsRelatives as $key => $newsRelative)
                                    <li>
                                        <a href="{{ route('news.show', $newsRelative->slug) }}" class="hover-effect">
                                            <img data-original="{{ $newsRelative->image }}"
                                                 alt="{{ $newsRelative->slug }}"
                                                 class="middle-item"/>
                                        </a>
                                        <h5 class="caption">{{ $newsRelative->name }}</h5>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
            @endif

            <!-- comment list -->
                <div class="comments-container block">
                    <h2 id="comment_count">{{ $commentCount }} @lang('messages.frontend-comments')</h2>
                    <ul id="comment_list" class="comment-list travelo-box">
                        @if (count($newsIndex->comments) == 0)
                            <div id="no-comment">@lang('messages.frontend-no-comments')</div>
                        @else
                            @foreach($newsIndex->comments as $key => $comment)
                                @include('frontend._partials.comment_item',['slug'=> $newsIndex->slug])
                            @endforeach
                            @if(count($newsIndex->comments) > 5 )
                                <hr>
                                <button id="loadMore"
                                        class="btn-large full-width">@lang('messages.frontend_load_more_comment')</button>
                            @endif
                        @endif
                    </ul>
                </div>
                <!-- comment list -->

                <!-- comment -->
                <div class="post-comment block">
                    <h2 class="reply-title">@lang('messages.frontend-post-comment')</h2>
                    <div class="travelo-box">
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
                        <div class="notice-recharge"></div>
                    </div>
                </div>
            @include('_partials.card_item')
            <!-- comment -->
            </div>
            <div class="sidebar col-md-3">
                <div class="tab-container box">
                    <div class="travelo-box">
                        <h5 class="box-title">@lang('messages.search')</h5>
                        <form action="{{ route('news') }}" method="GET">
                            <div class="with-icon full-width">
                                <input type="text" name="search[name]" value="{{ $search }}"
                                       class="input-text full-width"
                                       placeholder="@lang('messages.frontend-search-placeholder')">
                                <button type="submit" class="icon green-bg white-color"><i class="soap-icon-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <ul class="tabs full-width">
                        <li class="active"><a data-toggle="tab"
                                              href="#recent-posts">@lang('messages.frontend-news-recent')</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="recent-posts" class="tab-pane fade in active">
                            <div class="image-box style14">
                                @foreach($newsRecent as $key => $news)
                                    <article class="box">
                                        <figure><a href="{{ route('news.show', $news->slug) }}"
                                                   title="{{ $news->name }}"><img width="63" height="59"
                                                                                  data-original="{{ $news->image }}"
                                                                                  alt="{{ $news->slug }}"></a>
                                        </figure>
                                        <div class="details recent-news">
                                            <h5 class="box-title"><a
                                                        href="{{ route('news.show', $news->slug) }}">{{ $news->name }}</a>
                                            </h5>
                                            <p class="font-10"><i class="fa fa-clock-o"></i> {{ $news->created_at }}
                                            </p>
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



