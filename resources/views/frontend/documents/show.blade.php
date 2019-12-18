@extends('layouts.frontend')

@section('page_title')
    @include('frontend._partials.breadcrumbs', ['breadcrumbs' => Breadcrumbs::generate('documents.show',$document)])
@endsection

@section('content')
    <div class="container flight-detail-page">
        <div class="row">
            <div class="notice-recharge"></div>
            <div class="sidebar col-md-3">
                <article class="detailed-logo">
                    <figure>
                        <img data-original="/public/{{ $document->image }}" alt="{{ $document->slug }}">
                    </figure>
                    <div class="details">
                        <h2 class="box-title">{{ $document->name }}<small><i class="soap-icon-clock"></i> {{ $document->updated_at }}</small></h2>
                                <span class="price clearfix">
                                    <small class="pull-left">@lang('messages.frontend-comments') / @lang('messages.frontend-views')</small>
                                    <span id="comment_view" class="pull-right">{{ $document->comment_counts }} / {{ $document->view_counts }}</span>
                                </span>

                        {{--#TODO: THỰC HIỆN HIỂN THỊ META DATA--}}
                        @foreach($documentMetaValues as $key => $documentMeta)
                            <div class="duration">
                                <dl>
                                    <dt class="skin-color" style="min-width: 90px; width: 90px;">{{ $documentMeta->documentMeta->name }}: </dt>
                                    <dd>{{ $documentMeta->value }}</dd>
                                </dl>
                            </div>
                        @endforeach

                        @if (!empty($document->short_description))
                            <div class="description text-justify">{!! $document->short_description !!}</div>
                        @endif

                    </div>
                </article>

                <div class="jquery-accordion-menu white">
                    <div class="jquery-accordion-menu-header uppercase"><i
                                class="fa fa-th"></i> @lang('messages.frontend-doc-categories') </div>
                    <ul>
                        @php
                            $parent_id = 0;
                            $last_name = '';
                        @endphp
                        @foreach($categoryDocs as $key => $category)
                            @if ($key != 0 && $parent_id != $category->parent_id)
                                @for( $i = 0; $i < substr_count($last_name, '&nbsp;&nbsp;&nbsp;&nbsp') - substr_count($category->name, '&nbsp;&nbsp;&nbsp;&nbsp'); $i++ )
                    </ul>
                    </li>
                    @endfor
                    @endif
                    @php $level = substr_count($category->name, '&nbsp;&nbsp;&nbsp;&nbsp;'); @endphp
                    {{--CÓ CON THÌ LUÔN MỞ--}}
                    @if (count($category->children()) > 0)
                        <li @if($categorySlug == $category->slug && $type == 'documents') class="active" @endif>
                            <a href="{{ route('documents') }}?danh-muc={{ $category->slug }}"><i
                                        class="fa fa-angle-double-right"></i> {{ strlen($category->name)>25+$level*24? substr($category->name, 0, strpos($category->name,' ',25+$level*24)).'...' : $category->name }} ({{ count($category->documents) }})
                            </a><span class="submenu-indicator"><i class="fa fa-plus"></i></span>

                            <ul class="submenu">

                                @php
                                    $parent_id = $category->id
                                @endphp
                                @endif

                                {{--KHÔNG CÓ CON THÌ TỰ ĐÓNG--}}
                                @if (count($category->children()) == 0)
                                    <li @if($categorySlug == $category->slug && $type == 'documents') class="active" @endif>
                                        <a href="{{ route('documents') }}?danh-muc={{ $category->slug }}"><i
                                                    class="fa fa-angle-double-right"></i>{{ strlen($category->name)>30+$level*24? substr($category->name, 0, strpos($category->name,' ',30+$level*24)).'...' : $category->name }} ({{ count($category->documents) }})</a>
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
                    <h2>{{ $document->name }}</h2>
                    <hr>
                    {{--@if(!empty($document->short_file) && file_exists(public_path($document->short_file)))
                        <iframe src="https://docs.google.com/viewer?embedded=true&url={{ url('/').$document->short_file }}" style="width:100%; height:500px;" frameborder="0"></iframe>
                    @endif--}}
                    <div class="row">
                        <div class="col-lg-12">
                            @if(!empty($document->file) && file_exists(public_path($document->file)))
                                <a id="minus_money_file" @if(Auth::check()) data-toggle="modal" data-target="#modal-minus-money" class="button btn-small edit-profile-btn pull-right" @else href="#dang-nhap" class="button btn-small edit-profile-btn pull-right soap-popupbox" @endif
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
                            @if(!empty($document->link_download))
                                <a id="minus_money" @if(Auth::check()) data-toggle="modal" data-target="#modal-minus-money-link" class="button btn-small edit-profile-btn pull-right" @else href="#dang-nhap" class="button btn-small edit-profile-btn pull-right soap-popupbox" @endif
                                style="background-color: #01b7f2; margin-right: 15px">@lang('messages.link_download')</a>
                            @endif
                        </div>
                    </div>
                    <p><strong>{!! $document->short_description !!}</strong></p>
                    <p>{!! $document->description !!}</p>
                </div>

                <div class="modal fade" id="modal-minus-money-link" style="display: none;">
                    <form id="confirm_minus_money_link">
                        {{ csrf_field() }}
                        @php $trans_type="download_2" @endphp
                        @include('_partials.confirm_minus_money')
                        <input type="hidden" id="slug" name="slug" value="{{explode("/", Request::path())[1]}}">
                    </form>
                </div>

                @if (!count($documentRelatives) == 0)
                    <h2>@lang('messages.frontend-document-relative')</h2>
                    <div class="travelo-box">
                        <div class="suggestions image-carousel style2 relative" data-animation="slide" data-item-width="150" data-item-margin="22">
                            <ul class="slides">
                                @foreach($documentRelatives as $key => $documentRelative)
                                    <li>
                                        <a href="{{ route('documents.show', $documentRelative->slug) }}" class="hover-effect">
                                            <img data-original="/public/{{ $documentRelative->image }}" alt="{{ $documentRelative->slug }}" class="middle-item"/>
                                        </a>
                                        <h5 class="caption">{{ $documentRelative->name }}</h5>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <div class="comments-container block">
                    <h2 id="comment_count">{{ $commentCount }} @lang('messages.frontend-comments')</h2>
                    <ul id="comment_list" class="comment-list travelo-box">
                        @if (count($document->comments) == 0)
                            <div id="no-comment">@lang('messages.frontend-no-comments')</div>
                        @else
                            @foreach($document->comments as $key => $comment)
                                @include('frontend._partials.comment_item',['slug'=> $document->slug])
                            @endforeach
                            @if(count($document->comments) > 5 )
                                <hr>
                                <button id="loadMore" class="btn-large full-width">@lang('messages.frontend_load_more_comment')</button>
                            @endif
                        @endif
                    </ul>
                </div>
                <input type="hidden" id="comment_id" value="0">
                <!-- comment -->
                <div class="modal fade" id="modal-minus-money-comment" style="display: none;">
                    <form id="confirm_minus_money_comment">
                        {{ csrf_field() }}
                        @php $trans_type="comment" @endphp
                        @include('_partials.confirm_minus_money')
                        <input type="hidden" id="slug" name="slug" value="{{explode("/", Request::path())[1]}}">
                    </form>
                </div>
                <div class="post-comment block">
                    <h2 class="reply-title">@lang('messages.frontend-post-comment')</h2>
                    <div class="travelo-box">
                        @if(Auth::check())
                            <form class="comment-form" id="comment_doc">

                                <div class="form-group">
                                    <label>@lang('messages.frontend-comment-message')</label>
                                    <textarea id="content-comment" name="content" rows="6" class="input-text full-width" placeholder="@lang('messages.frontend-comment-message-placeholder')"></textarea>
                                </div>
                                {{ csrf_field() }}
                                <input type="hidden" id="slug" name="slug" value="{{explode("/", Request::path())[1]}}">
                                <input type="hidden" id="parent_id" name="parent_id" value="0">

                                <button type="button" onclick="jQuery('#loading_comment').html(''); return jQuery('#modal-minus-money-comment').modal('show')" id="post-btn" disabled style="background-color: #f5f5f5;color: black" class="btn-large full-width">@lang('messages.frontend-comment-submit')</button>
                                {{--<button type="submit" onclick="jQuery('#loading_comment').html('');" id="post-btn" disabled style="background-color: #f5f5f5;color: black" class="btn-large full-width">@lang('messages.frontend-comment-submit')</button>--}}
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
                        <li class="active"><a data-toggle="tab" href="#recent-posts">@lang('messages.frontend-recent')</a></li>
                        <li><a data-toggle="tab" href="#views-posts">@lang('messages.frontend-views')</a></li>
                        <li><a data-toggle="tab" href="#comments-posts">@lang('messages.frontend-comments')</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="recent-posts" class="tab-pane fade in active">
                            <div class="image-box style14">
                                @foreach($documentRecent as $key => $document)
                                    <article class="box">
                                        <figure><a href="{{ route('documents.show', $document->slug) }}" title="{{ $document->name }}"><img width="63" height="59" data-original="/public/{{ $document->image }}" alt="{{ $document->slug }}"></a></figure>
                                        <div class="details">
                                            <h5 class="box-title"><a href="{{ route('documents.show', $document->slug) }}">{{ $document->name }}</a></h5>
                                            <label class="price-wrapper"><span class="price-per-unit"><i class="fa fa-eye"></i> {{ $document->view_counts }} / <i class="fa fa-comments-o"></i> {{ $document->comment_counts }}</span></label>
                                            <p class="font-10"><i class="fa fa-clock-o"></i> {{ $document->created_at }}</p>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </div>
                        <div id="views-posts" class="tab-pane fade">
                            <div class="image-box style14">
                                @foreach($documentViews as $key => $document)
                                    <article class="box">
                                        <figure><a href="{{ route('documents.show', $document->slug) }}" title="{{ $document->name }}"><img width="63" height="59" data-original="/public/{{ $document->image }}" alt="{{ $document->slug }}"></a></figure>
                                        <div class="details">
                                            <h5 class="box-title"><a href="{{ route('documents.show', $document->slug) }}">{{ $document->name }}</a></h5>
                                            <label class="price-wrapper"><span class="price-per-unit"><i class="fa fa-eye"></i> {{ $document->view_counts }} / <i class="fa fa-comments-o"></i> {{ $document->comment_counts }}</span></label>
                                            <p class="font-10"><i class="fa fa-clock-o"></i> {{ $document->created_at }}</p>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </div>
                        <div id="comments-posts" class="tab-pane fade">
                            <div class="image-box style14">
                            @foreach($documentComments as $key => $document)
                                <article class="box">
                                    <figure><a href="{{ route('documents.show', $document->slug) }}" title="{{ $document->name }}"><img width="63" height="59" data-original="/public/{{ $document->image }}" alt="{{ $document->slug }}"></a></figure>
                                    <div class="details">
                                        <h5 class="box-title"><a href="{{ route('documents.show', $document->slug) }}">{{ $document->name }}</a></h5>
                                        <label class="price-wrapper"><span class="price-per-unit"><i class="fa fa-eye"></i> {{ $document->view_counts }} / <i class="fa fa-comments-o"></i> {{ $document->comment_counts }}</span></label>
                                        <p class="font-10"><i class="fa fa-clock-o"></i> {{ $document->created_at }}</p>
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
                        <span class="contact-phone"><i class="soap-icon-phone"></i> Hotline: {{ config('system.phone.value') }}</span>
                        <br>
                        <span class="contact-phone"><i class="soap-icon-letter"></i> {{ config('system.contact.value') }}</span>
                    </address>
                </div>
            </div>
        </div>
    </div>
@endsection



