<article class="box">
    <figure class="col-sm-3 col-md-2">
        <a href="{{ route('courses.show', $course->slug) }}" class=""><img class="padding-5" alt="{{ $course->slug }}" data-original="/public/{{ $course->image }}"></a>
    </figure>
    <div class="details col-sm-9 col-md-10">
        <div>
            <div>
                <h4 class="box-title">
                    <a href="{{ route('courses.show', $course->slug) }}">{{ $course->name }}</a>
                    <small>
                        @if ($course->center->id == 0)
                            <i class="soap-icon-businessbag yellow-color"></i> @lang('messages.no-value')
                        @else
                            <a href="{{ route('centers.show', $course->center->slug) }}"><i
                                        class="soap-icon-businessbag yellow-color"></i> {{ $course->center->name }}</a>
                        @endif
                        ,
                        @if ($course->teacher->id == 0)
                            <i class="fa fa-user yellow-color yellow-color"></i> @lang('messages.no-value')
                        @else
                                <a href="{{ route('teachers.show', $course->teacher->slug) }}"><i
                                            class="fa fa-user yellow-color"></i> {{ $course->teacher->name }}</a>
                        @endif
                        {!! (empty($course->start_date)?'':', <i class="fa fa-clock-o yellow-color"></i> '.$course->start_date->format('d/m/Y h:m')) . (empty($course->end_date)?'':(empty($course->start_date)?', <i class="fa fa-clock-o yellow-color"></i> '.$course->end_date->format('d/m/Y h:m'):'-'.$course->end_date->format('d/m/Y h:m')))  !!}
                    </small>
                </h4>
            </div>
            <div>

                <span class="price yellow-color"><i
                            class="fa fa-money"></i> {{ empty($course->cost)? __('messages.no-value') : Helper::format_money($course->cost) }}</span>
            </div>
        </div>
        <div>
            <div>
                {!! $course->short_description!!}
            </div>
            <div>
                <a class="button btn-small full-width text-center"
                   href="{{ route('courses.show', $course->slug) }}">@lang('messages.frontend-details')</a>
            </div>
        </div>
    </div>
</article>