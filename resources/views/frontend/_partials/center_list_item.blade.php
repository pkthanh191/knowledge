<article class="box">
    <figure class="col-sm-3 col-md-2">
        <a href="{{ route('centers.show', $center->slug) }}" class=""><img class="padding-5" alt="{{ $center->slug }}" data-original="/public/{{ $center->image }}"></a>
    </figure>
    <div class="details col-sm-9 col-md-10">
        <div>
            <div>
                <h4 class="box-title">
                    <a href="{{ route('centers.show', $center->slug) }}">{{ $center->name }}</a>
                    <small><i class="fa fa-map-marker yellow-color"></i>  {{ empty($center->address)? __('messages.no-value') : $center->address }}&nbsp;&nbsp;<i class="fa fa-clock-o yellow-color"></i> {{ $center->updated_at }} </small>
                </h4>
            </div>
            <div>
                <span class="price yellow-color"><i class="fa fa-mobile-phone"></i>  {{ empty($center->phone)? __('messages.no-value') : $center->phone }}</span>
            </div>
        </div>
        <div>
            <div>{!! $center->short_description!!}</div>
            <div>
                <a class="button btn-small full-width text-center" href="{{ route('centers.show', $center->slug) }}">@lang('messages.frontend-details')</a>
            </div>
        </div>
    </div>
</article>