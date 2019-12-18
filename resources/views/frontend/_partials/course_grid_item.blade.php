<div class="col-sm-6 col-md-3">
    <article class="box">
        <figure>
            <a href="{{route('courses.show',$course->slug)}}" class="text-center"><img class="center-img" alt="{{ $course->slug }}" data-original="/public/{{ $course->image }}"></a>
        </figure>
        <div class="details">
            <h5 class="box-title text-center height-34">
                <a href="{{ route('courses.show', $course->slug) }}" title="{{$course->name}}">{{ (Helper::subDescription($course->name, '', 80, false) )}}</a>
            </h5>
            <hr class="center-seperator">
            <span class="center-sub-info height-26"><i class="fa fa-map-marker"></i> {{ empty($course->center->address)? __('messages.no-value'): Helper::subDescription($course->center->address, '', 60, false)}}</span>

            <hr class="center-seperator">
            <div class="action text-center">
                <a class="button btn-small yellow readmore" href="{{ route('courses.show', $course->slug) }}">@lang('messages.frontend-details')</a>
            </div>
        </div>
    </article>
</div>