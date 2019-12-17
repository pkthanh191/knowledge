@extends('layouts.frontend')

@section('page_title')
    @include('frontend._partials.breadcrumbs', ['breadcrumbs' => Breadcrumbs::generate('courses.show', $course)])
@endsection

@section('content')
    <div class="container flight-detail-page">
        <div class="row">
            <div class="sidebar col-md-3">
                <article class="detailed-logo">
                    <figure>
                        <img data-original="{{ $course->image }}" alt="{{ $course->slug }}" style="width: 100%">
                    </figure>
                    <div class="details">
                        <h2 class="box-title">{{ $course->name }}
                            <small><i class="soap-icon-clock"></i> {{ $course->updated_at }}</small>
                        </h2>
                        <div class="duration">
                            <dl>
                                {{--<a href="{{route('centers.show', $course->center->slug)}}"></a>--}}
                                <dt class="skin-color"
                                    style="width: 110px;">@lang('messages.center_name'):
                                </dt>
                                <a href="{{route('centers.show',$course->center->slug)}}">
                                    <fv>@if($course->center->id != 0){{ $course->center->name }}@endif</fv>
                                </a>
                            </dl>
                        </div>
                        <div class="duration">
                            <dl>
                                <dt class="skin-color" style="width: 110px;">@lang('messages.teachers')
                                    :
                                </dt>
                                <a href="{{route('teachers.show',$course->teacher->slug)}}">
                                    <dd>@if($course->teacher->id != 0){{ $course->teacher->name }}@endif</dd>
                                </a>
                            </dl>
                        </div>
                        <div class="duration">
                            <dl>
                                <dt class="skin-color" style="width: 110px;">@lang('messages.course_start_date'):</dt>
                                <dd>{{ empty($course->start_date)?'':$course->start_date->format('d-m-Y') }}</dd>
                            </dl>
                        </div>
                        <div class="duration">
                            <dl>
                                <dt class="skin-color" style="width: 110px;">@lang('messages.course_end_date'):</dt>
                                <dd>{{ empty($course->end_date)?'':$course->end_date->format('d-m-Y') }}</dd>
                            </dl>
                        </div>
                        <div class="duration">
                            <dl>
                                <dt class="skin-color" style="width: 110px;">@lang('messages.course_cost'):</dt>
                                <dd>{{ Helper::format_money($course->cost) }}</dd>
                            </dl>
                        </div>
                        <div class="duration">
                            <dl>
                                <dt class="skin-color" style="width: 110px;">@lang('messages.course_category'):</dt>
                                <dd>
                                    @foreach($course->categories as $key=>$category)
                                        @if($key>0)<br>{{$category->name}}
                                        @else {{$category->name}}
                                        @endif
                                    @endforeach
                                </dd>
                            </dl>
                        </div>

                        @if (!empty($course->short_description))
                            <p class="description text-justify">{!! $course->short_description !!}</p>
                        @endif
                        {{--<a href="#" class="button green full-width uppercase btn-medium">book flight now</a>--}}
                    </div>
                </article>
                @include('frontend._partials.menu-course-categories')
            </div>
            <div id="main" class="col-md-6">
                <div class="long-description travelo-box">
                    <h2>{{ $course->name }}</h2>
                    <hr>
                    <div class="text-justify"><strong>{!! $course->short_description !!}</strong></div>
                    <div class="text-justify">{!! $course->description !!}</div>
                </div>

                @if (!count($courseRelatives) == 0)
                    <h2>@lang('messages.frontend-course-relative')({{count($courseRelatives)}})</h2>
                    <div class="travelo-box">
                        <div class="suggestions image-carousel style2 relative" data-animation="slide"
                             data-item-width="150" data-item-margin="22">
                            <ul class="slides">
                                @foreach($courseRelatives as $key => $courseRelative)
                                    <li>
                                        <a href="{{ route('courses.show', $courseRelative->slug) }}"
                                           class="hover-effect">
                                            <img data-original="{{ $courseRelative->image }}" alt="{{ $courseRelative->slug }}"
                                                 class="middle-item"/>
                                        </a>
                                        <a href="{{ route('courses.show', $courseRelative->slug) }}"><h5
                                                    class="caption">{{ $courseRelative->name }}</h5></a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

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
                                @foreach($courseRecent as $key => $course)
                                    <article class="box">
                                        <figure><a href="{{ route('courses.show', $course->slug) }}"
                                                   title="{{ $course->name }}"><img width="63" height="59"
                                                                                    data-original="{{ $course->image }}"
                                                                                    alt="{{ $course->slug }}"></a>
                                        </figure>
                                        <div class="details">
                                            <h5 class="box-title"><a
                                                        href="{{ route('courses.show', $course->slug) }}">{{ $course->name }}</a>
                                            </h5>
                                            {{--<label class="price-wrapper"><span class="price-per-unit"><i class="fa fa-eye"></i> {{ $course->view_counts }} / <i class="fa fa-comments-o"></i> {{ $course->comment_counts }}</span></label>--}}
                                            <p class="font-10"><i class="fa fa-clock-o"></i> {{ $course->created_at }}
                                            </p>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </div>
                        <div id="views-posts" class="tab-pane fade">
                            <div class="image-box style14">
                                @foreach($courseViews as $key => $course)
                                    <article class="box">
                                        <figure><a href="{{ route('courses.show', $course->slug) }}"
                                                   title="{{ $course->name }}"><img width="63" height="59"
                                                                                    data-original="{{ $course->image }}"
                                                                                    alt="{{ $course->slug }}"></a>
                                        </figure>
                                        <div class="details">
                                            <h5 class="box-title"><a
                                                        href="{{ route('courses.show', $course->slug) }}">{{ $course->name }}</a>
                                            </h5>
                                            <label class="price-wrapper"><span class="price-per-unit"><i
                                                            class="fa fa-eye"></i> {{ $course->view_counts }} / <i
                                                            class="fa fa-comments-o"></i> {{ $course->comment_counts }}</span></label>
                                            <p class="font-10"><i class="fa fa-clock-o"></i> {{ $course->created_at }}
                                            </p>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </div>
                        <div id="comments-posts" class="tab-pane fade">
                            <div class="image-box style14">
                                @foreach($courseComments as $key => $course)
                                    <article class="box">
                                        <figure><a href="{{ route('courses.show', $course->slug) }}"
                                                   title="{{ $course->name }}"><img width="63" height="59"
                                                                                    data-original="{{ $course->image }}"
                                                                                    alt="{{ $course->slug }}"></a>
                                        </figure>
                                        <div class="details">
                                            <h5 class="box-title"><a
                                                        href="{{ route('courses.show', $course->slug) }}">{{ $course->name }}</a>
                                            </h5>
                                            <label class="price-wrapper"><span class="price-per-unit"><i
                                                            class="fa fa-eye"></i> {{ $course->view_counts }} / <i
                                                            class="fa fa-comments-o"></i> {{ $course->comment_counts }}</span></label>
                                            <p class="font-10"><i class="fa fa-clock-o"></i> {{ $course->created_at }}
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
                        <span class="contact-phone"><i class="soap-icon-phone"></i> Hotline: {{ config('system.phone.value') }}</span>
                        <br>
                        <span class="contact-phone"><i class="soap-icon-letter"></i> {{ config('system.contact.value') }}</span>
                    </address>
                </div>
            </div>
        </div>
    </div>
@endsection


