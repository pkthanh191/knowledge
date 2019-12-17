<article class="box">
    <div class="col-sm-6 col-md-6 document-container">
        <figure class="col-sm-4 col-md-4 no-padding">
            <a title="" href="{{ route('documents.show', $document->slug) }}" class=""><img class="padding-5" alt="{{ $document->slug }}" data-original="{{ $document->image }}"></a>
            <div class="item-review">
                <span class=""><i class="fa fa-comments-o"></i>  {{ count($document->comments) }}</span> / <span class=""><i class="fa fa-eye"></i>  {{ $document->view_counts }}</span>
            </div>
        </figure>
        <div class="col-md-8">
            <h4 class="box-title">
                <a href="{{ route('documents.show', $document->slug) }}">{{ $document->name }}</a>
                <small><i class="fa fa-clock-o yellow-color"></i> {{ $document->updated_at }}</small>
            </h4>
            <div class="box-desc">
                {!! (\App\Helpers\Helper::subDescription($document->short_description,'', 500, false)) !!}
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-6 comments-container">
        <div class="comments">
            <h4 class="box-title">Thảo luận: {{ count($document->comments) }} thảo luận</h4>
            <hr>
            @if(count($document->comments) > 0)
                {{--@foreach($document->comments->reverse() as $key => $comment)--}}
                @foreach($document->comments as $key => $comment)
                    <p>
                        <i class="fa fa-comments-o"></i> <b>{{ $comment->user->name }}</b>: {!! Helper::makeLinks(Helper::rip_tags($comment->content),$comment->id, $document->slug, '/tai-lieu/'.$document->slug) !!}
                        <br>
                        <small style="color: #90949c;">{!! $comment->created_at !!} - {!! (\App\Helpers\Helper::facebook_time_ago($comment->created_at)) !!}</small>
                    </p>
                @endforeach
            @else
                <div class="box-desc">
                    Không có thảo luận.
                </div>
            @endif
        </div>
    </div>
</article>