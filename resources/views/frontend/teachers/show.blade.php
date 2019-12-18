@extends('layouts.frontend')

@section('page_title')
    @include('frontend._partials.breadcrumbs', ['breadcrumbs' => Breadcrumbs::generate('teachers.show',$teacher)])
@endsection

@section('content')
    <div class="container flight-detail-page">
        <div class="row">
            <div class="sidebar col-md-3">
                <article class="detailed-logo">
                    <figure>
                        <img data-original="/public/{{ $teacher->image }}" alt="{{ $teacher->slug }}">
                    </figure>
                    <div class="details">
                        <h2 class="box-title">{{ $teacher->name }}</h2>
                        <div class="duration">
                            <dl>
                                <i class="fa fa-phone" style="width: 20px;"></i> {{ $teacher->phone }}
                            </dl>
                        </div>
                        <div class="duration">
                            <dl>
                                <i class="fa fa-envelope-o" aria-hidden="true" style="width: 20px;"></i> {{ $teacher->email }}
                            </dl>
                        </div>
                        <div class="duration">
                            <dl>
                                <i class="fa fa-map-marker" aria-hidden="true" style="width: 20px;"></i> {{ $teacher->address }}
                            </dl>
                        </div>
                    </div>
                </article>

                @if($center->id != 0)
                <article class="detailed-logo">
                    <figure>
                        <img data-original="/public/{{ $center->image }}" alt="{{ $center->slug }}">
                    </figure>
                    <div class="details">
                        <h2 class="box-title">  <a href="{{route('centers.show', $center->slug)}}">{{ $center->name }}</a></h2>

                        <div class="duration">
                            <dl>
                                <i class="fa fa-phone" style="width: 20px;"></i> {{$center->phone}}
                            </dl>
                        </div>

                        <div class="duration">
                            <dl>
                                <i class="fa fa-envelope-o" style="width: 20px;" aria-hidden="true"></i> {{$center->email}}
                            </dl>
                        </div>

                        <div class="duration">
                            <dl>
                                <i class="fa fa-map-marker" aria-hidden="true" style="width: 20px;"></i> {{$center->address}}
                            </dl>
                        </div>

                        @if (!empty($center->short_description))
                            <div class="description text-justify">{!! $center->short_description !!}</div>
                        @endif
                        {{--<a href="#" class="button green full-width uppercase btn-medium">book flight now</a>--}}
                    </div>
                </article>
                @endif
                <div class="jquery-accordion-menu white">
                    <div class="jquery-accordion-menu-header uppercase"><i class="fa fa-th"></i> @lang('messages.frontend-center-categories') </div>
                    <ul>
                        <li @if($type == 'centers') class="active" @endif><a href="{{ route('centers') }}"><i class="fa fa-angle-double-right"></i> @lang('messages.frontend-centers') ({{$centerCount - 1}})</a></li>
                        <li @if($type == 'teachers') class="active" @endif><a href="{{ route('teachers') }}"><i class="fa fa-angle-double-right"></i> @lang('messages.frontend-teachers') ({{$teacherCount - 1}})</a></li>
                        <li @if($type == 'courses') class="active" @endif><a href="{{ route('courses') }}"><i class="fa fa-angle-double-right"></i> @lang('messages.frontend-courses') ({{$courseCount}})</a></li>
                    </ul>
                </div>
            </div>
            <div id="main" class="col-md-6">
                <div class="long-description travelo-box">
                    <h2>{{ $teacher->name }}</h2>
                    <hr/>
                    <div class="text-justify">{!! $teacher->description !!}</div>
                </div>

                <div class="travelo-box">
                    <h2>@lang('messages.frontend-teacher-courses')</h2>
                    <hr/>
                    @if(count($courses)>0)
                        @foreach($courses as $key => $course)
                            <article class="box">
                                <figure><a href="{{ route('courses.show', $course->slug) }}" title="{{ $course->name }}"><img width="63" height="59" data-original="/public/{{ $course->image }}" alt="{{ $course->slug }}"></a></figure>
                                <div class="details">
                                    <h5 class="box-title"><a href="{{ route('courses.show', $course->slug) }}">{{ $course->name }}</a></h5>
                                    <p class="font-10"><i class="fa fa-clock-o"></i> {{ $course->start_date }}</p>
                                </div>
                            </article>
                        @endforeach
                    @else
                        <p>@lang('messages.not-found-course')</p>
                    @endif
                </div>

                @if (!count($other_teachers) == 0)
                    <h2>@lang('messages.frontend-teacher-other') ({{ count($other_teachers) }}) </h2>
                    <div class="travelo-box">
                        <div class="suggestions image-carousel style2 relative" data-animation="slide" data-item-width="150" data-item-margin="22">
                            <ul class="slides">
                                @foreach($other_teachers as $key => $other_teacher)
                                    <li>
                                        <a href="{{ route('teachers.show', $other_teacher->slug) }}" class="hover-effect">
                                            <img data-original="/public/{{ $other_teacher->image }}" alt="{{ $other_teacher->slug }}" class="middle-item"/>
                                        </a>
                                        <h5 class="caption">{{ $other_teacher->name }}</h5>
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