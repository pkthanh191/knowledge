<div class="row white-block" style="margin-left: 0px; margin-right: 0px; margin-top: 15px;">
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
                            <a href="{{ route('centers.show', $center->slug) }}" class="text-center"><img class="document-img-home-center" alt="{{ $center->slug }}" data-original="/public/{{ $center->image }}"></a>
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
            @endforeach
        </div>
    </div>
</div>

@if($centers->hasPages())
    <div class="box-footer">
        {!! $centers->appends(['search' => Request::get('search'), 'mode' => 'grid', 'danh-muc'=>Request::get('danh-muc')])->render() !!}
    </div>
@endif