<div class="col-sm-6 col-md-3">
    <article class="box">
        <figure>
            <a href="{{ route('teachers.show', $teacher->slug) }}" class="text-center"><img class="center-img"
                                                                                            alt="{{ $teacher->slug }}"
                                                                                            data-original="{{ $teacher->image }}"></a>
        </figure>
        <div class="details">
            <h5 class="box-title text-center height-26">
                <a href="{{ route('teachers.show', $teacher->slug) }}">{{ $teacher->name }}</a>
            </h5>
            <div class="feedback">
                <span class="center-sub-info"><i class="fa fa-mobile-phone"></i> {{ $teacher->phone }}</span>
                @if($teacher->center->id != 0)
                    <hr class="center-seperator">
                    <span class="center-sub-info height-26">
                        <a href="{{ route('centers.show', $teacher->center->slug) }}"><i
                                    class="soap-icon-businessbag"></i> {{ $teacher->center->name }}</a>
                </span>
                @else
                    <hr class="center-seperator">
                    <span class="center-sub-info height-26">
                        <i class="soap-icon-businessbag"></i> @lang('messages.no-value')
                    </span>
                @endif

                <hr class="center-seperator">
                <span class="center-sub-info"><i class="fa fa-clock-o"></i> {{ $teacher->updated_at }}</span>
            </div>
            <div class="action text-center">
                <a href="{{ route('teachers.show', $teacher->slug) }}"
                   class="button btn-small yellow readmore">@lang('messages.frontend-details')</a>
            </div>
        </div>
    </article>
</div>