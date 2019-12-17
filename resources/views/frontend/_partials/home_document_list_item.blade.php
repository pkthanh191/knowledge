<div class="col-sm-6 col-md-3">
    <article class="box">
        <figure>
            <a href="#" class="hover-effect popup-gallery text-center"><img class="document-img" alt="{{ $document->slug }}" data-original="{{ $document->image }}"></a>
        </figure>
        <div class="details">
            <h5 class="box-title text-center">
                {{ $document->name }}<small><i class="fa fa-clock-o"></i> {{ $document->updated_at }}</small>
            </h5>
            <div class="feedback">
                <span class="comment-counts"><i class="fa fa-eye"></i>  {{ $document->view_counts }}</span>
                <span class="view-counts"><i class="fa fa-comments-o"></i>  {{ $document->comment_counts }}</span>
            </div>
            <div class="action text-center">
                <a class="button btn-small yellow readmore">@lang('messages.frontend-details')</a>
            </div>
        </div>
    </article>
</div>