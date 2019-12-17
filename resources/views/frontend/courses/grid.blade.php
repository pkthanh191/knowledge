<div class="row white-block" style="margin-left: 0px; margin-right: 0px; margin-top: 15px;">
    <h2 class="header-home">
        <a href="{{ route('courses') }}" class="uppercase">@lang('messages.frontend-courses')</a>
    </h2>
    <hr>
    <div class="hotel-list" id="course-container">
        <div id="course-row-{{ $row_course = 0 }}">
            @foreach($courses as $key => $course)
                <div class="col-sm-6 col-md-2 item-padding">
                    <article class="box">
                        <figure>
                            <a href="{{ route('courses.show', $course->slug) }}" class="text-center"><img class="document-img-home-center" alt="{{ $course->slug }}" data-original="{{ $course->image }}"></a>
                        </figure>
                        <div class="details">
                            <h5 class="box-title text-center">
                                <a href="{{ route('courses.show', $course->slug) }}">{{ (\App\Helpers\Helper::subDescription($course->name,'',55, false) )}}</a>
                                <br/>
                                <small style="text-transform: none;"><i class="fa fa-map-marker"></i> {{ empty($course->center->address)? __('messages.no-value'): Helper::subDescription($course->center->address, '', 40, false)}}</small>
                            </h5>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</div>

@if($courses->hasPages())
    <div class="box-footer">
        {!! $courses->appends(['search' => Request::get('search'), 'mode' => 'grid', 'danh-muc'=>Request::get('danh-muc')])->render() !!}
    </div>
@endif