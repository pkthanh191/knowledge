<div class="row white-block">
    <h2 class="header-home">
        <a href="{{ route('centers') }}" class="uppercase">@lang('messages.frontend-home-center')</a>
    </h2>
    <hr>
    <div class="hotel-list" id="center-container">
        <div id="center-row-{{ $row_center=0 }}">
            @foreach($centers as $key => $center)
                <div class="col-sm-6 col-md-2 item-padding">
                    <article class="box">
                        <figure>
                            <a href="{{ route('centers.show', $center->slug) }}" class="text-center"><img class="document-img-home-center" alt="{{ $center->slug }}" data-original="{{ $center->image }}"></a>
                        </figure>
                        <div class="details">
                            <h5 class="box-title text-center">
                                <a href="{{ route('centers.show', $center->slug) }}">{{ (\App\Helpers\Helper::subDescription($center->name,'',45, false) )}}</a>
                                <br/>
                                <small style="text-transform: none;"><i class="fa fa-map-marker"></i> {{ empty($center->address)? __('messages.no-value'): Helper::subDescription($center->address, '', 40, false)}}</small>
                            </h5>
                        </div>
                    </article>
                </div>
                @if(($key+1)%6 == 0 && $key != count($centers)-1)
        </div>
        <div id="center-row-{{ ++$row_center }}" style="{{ $row_center > 1 ? "display: none" : "" }}">
            @endif
            @endforeach
        </div>
        <div class="clearfix"></div>
        @if(count($centers)> 12)
            <div class="text-center"><a id="loadMoreHomeCenter" href="javascript:;" class="button btn-small">@lang('messages.frontend_load_more') ↓ </a></div>
        @endif
    </div>
</div>