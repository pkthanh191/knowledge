<div class="row white-block" style="margin-left: 0px; margin-right: 0px; margin-top: 15px;">
    <div class="hotel-list" id="document-container">
        <div id="document-row-{{ $row_doc=0 }}">
            @foreach($documents as $key => $document)
                <div class="col-sm-6 col-md-2 item-padding">
                    <article class="box">
                        <figure>
                            <a href="{{ route('documents.show', $document->slug) }}" class="text-center"><img class="document-img-home" alt="{{ $document->slug }}" data-original="{{ $document->image }}"></a>
                        </figure>
                        <div class="detailspp">
                            <h5 class="box-title text-center">
                                <a href="{{ route('documents.show', $document->slug) }}">{{ (\App\Helpers\Helper::subDescription($document->name,'',45,false) ) }}</a>
                                <small><i class="fa fa-clock-o"></i> {{ $document->updated_at }}</small>
                                <small class="comment-views yellow-color"><i
                                            class="fa fa-eye"></i> {{ $document->view_counts }} / <i
                                            class="fa fa-comments-o"></i> {{ $document->comment_counts }}</small>
                            </h5>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</div>

@if($documents->hasPages())
    <div class="box-footer">
        {!! $documents->appends(['search' => Request::get('search'), 'mode' => 'grid', 'danh-muc'=>Request::get('danh-muc')])->render() !!}
    </div>
@endif