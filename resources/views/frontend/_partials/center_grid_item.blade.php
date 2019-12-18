<div class="col-sm-6 col-md-3">
    <article class="box">
        <figure>
            <a href="{{ route('centers.show', $center->slug) }}" class="text-center"><img class="center-img" alt="{{ $center->slug }}" data-original="/public/{{ $center->image }}"></a>
        </figure>
        <div class="details">
            <h5 class="box-title text-center height-34">
                <a href="{{ route('centers.show', $center->slug) }}" title="{{$center->name}}">{{ (Helper::subDescription($center->name, '', 80, false) )}}</a>
            </h5>
            <div class="feedback">
                <span class="center-sub-info"><i class="fa fa-mobile-phone"></i>  {{ $center->phone }}</span>
                <hr class="center-seperator">
                <span class="center-sub-info height-26"><i class="fa fa-map-marker"></i> {{ empty($center->address)? __('messages.no-value'): Helper::subDescription($center->address, '', 60, false)}}</span>
                <hr class="center-seperator">
                <span class="center-sub-info"><i class="fa fa-clock-o"></i> {{ $center->updated_at }}</span>
                {{--<span class="comment-counts"><i class="fa fa-envelope-o"></i>  {{ $center->email }}</span>--}}
            </div>
            <div class="action text-center">
                <a href="{{ route('centers.show', $center->slug) }}" class="button btn-small yellow readmore">@lang('messages.frontend-details')</a>
            </div>
        </div>
    </article>
</div>