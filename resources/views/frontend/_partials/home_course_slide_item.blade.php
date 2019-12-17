<div class="col-sm-6 col-md-3">
    <article class="box">
        <figure>
            <a href="#" class="hover-effect popup-gallery text-center"><img class="document-img" alt="{{ $course->slug }}" data-original="{{ $course->image }}"></a>
        </figure>
        <div class="details">
            <h5 class="box-title text-center">
                {{ $course->name }}<small><i class="fa fa-clock-o"></i> {{ $course->updated_at }}</small>
            </h5>
            <div class="feedback">
                <span class="comment-counts"><i class="fa fa-map-marker"></i>  {{ $course->address }}</span>
                {{--<span class="view-counts"><i class="fa fa-comments-o"></i>  {{ $course->comment_counts }}</span>--}}
            </div>
            <div class="action text-center">
                <a class="button btn-small yellow readmore">@lang('messages.frontend-details')</a>
            </div>
        </div>
    </article>
</div>