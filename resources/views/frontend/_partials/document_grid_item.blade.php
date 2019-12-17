<div class="col-sm-6 col-md-3">
    <article class="box">
        <figure>
            <a href="{{ route('documents.show', $document->slug) }}" class="text-center"><img class="document-img" alt="{{ $document->slug }}" data-original="{{ $document->image }}"></a>
        </figure>
        <div class="details">
            <h5 class="box-title text-center">
                <a href="{{ route('documents.show', $document->slug) }}">{{ $document->name }}</a>
                <small><i class="fa fa-clock-o"></i> {{ $document->updated_at }}</small>
                <small class="comment-views yellow-color"><i class="fa fa-eye"></i>  {{ $document->view_counts }} / <i class="fa fa-comments-o"></i>  {{ $document->comment_counts }}</small>
            </h5>
        </div>
    </article>
</div>