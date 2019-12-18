<div class="row white-block-list">
    <h2 class="header-home-list">
        <a href="{{ route('documents') }}" class="uppercase">@lang('messages.frontend-home-doc')</a>
    </h2>
</div>
<div class="row hotel-list listing-style3 hotel">
    @foreach($documents as $key => $document)
        @include('frontend._partials.document_list_item')
    @endforeach
</div>
<div class="row text-right">
    <a class="button btn-small text-center" style="margin-bottom: 15px;" title="" href="{{ route('documents') }}"> > Xem thêm</a>
</div>


{{--
<div class="row white-block">
    <div class="hotel-list" id="document-container">
        <div id="document-row-{{ $row_doc=0 }}">
            @foreach($documents as $key => $document)
                <div class="col-sm-6 col-md-2 item-padding">
                    <article class="box">
                        <figure>
                            <a href="{{ route('documents.show', $document->slug) }}" class="text-center"><img class="document-img-home" alt="{{ $document->slug }}" data-original="/public/{{ $document->image }}"></a>
                        </figure>
                        <div class="detailspp">
                            <h5 class="box-title text-center">
                                <a href="{{ route('documents.show', $document->slug) }}">{{ (\App\Helpers\Helper::subDescription($document->name,'', 45, false) )}}</a>
                                <small><i class="fa fa-clock-o"></i> {{ $document->updated_at }}</small>
                                <small class="comment-views yellow-color"><i
                                            class="fa fa-eye"></i> {{ $document->view_counts }} / <i
                                            class="fa fa-comments-o"></i> {{ $document->comment_counts }}</small>
                            </h5>
                        </div>
                    </article>
                </div>
                @if(($key+1)%6==0 && $key!=count($documents)-1)
            </div>
            <div id="document-row-{{ ++$row_doc }}" style="{{ $row_doc > 3? "display: none" : "" }}">
                @endif
            @endforeach
        </div>
        <div class="clearfix"></div>
        @if(count($documents)>24)
            <div class="text-center"><a id="loadMoreHomeDoc" href="javascript:;" class="button btn-small">@lang('messages.frontend_load_more') ↓</a></div>
        @endif
    </div>
</div>--}}
