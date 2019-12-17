<article class="box">
    <figure class="col-sm-3 col-md-2">
        <a href="{{ route('teachers.show', $teacher->slug) }}" class=""><img class="padding-5" alt="{{ $teacher->slug }}" data-original="{{ $teacher->image }}"></a>
    </figure>
    <div class="details col-sm-9 col-md-10">
        <div>
            <div>
                <h4 class="box-title">
                    <a href="{{ route('teachers.show', $teacher->slug) }}">{{ $teacher->name }}</a>
                    <small>
                        @if ($teacher->center->id == 0)
                           @lang('messages.no-value')
                        @else
                            <a href="{{ route('centers.show', $teacher->center->slug) }}"><i class="soap-icon-businessbag yellow-color"></i>  {{ $teacher->center->name }}</a>
                        @endif
                        &nbsp;&nbsp;<i class="fa fa-clock-o yellow-color"></i> {{ $teacher->updated_at }} </small>
                </h4>
            </div>
            <div>
                <span class="price yellow-color"><i class="fa fa-mobile-phone"></i>  {{ $teacher->phone }}</span>
            </div>
        </div>
        <div>
            <div>{!! Helper::subDescription($teacher->description, "", 300, false) !!}</div>
            <div>
                <a class="button btn-small full-width text-center" href="{{ route('teachers.show', $teacher->slug) }}">@lang('messages.frontend-details')</a>
            </div>
        </div>
    </div>
</article>