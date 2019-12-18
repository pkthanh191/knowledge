<article class="box">
    <div class="col-sm-6 col-md-6 document-container">
        <figure class="col-sm-4 col-md-4 no-padding">
            <a title="" href="{{ route('tests.show', $test->slug) }}" class=""><img class="padding-5" alt="{{ $test->slug }}" data-original="/public/{{ $test->image }}"></a>
            <div class="item-review">
                <span class=""><i class="fa fa-comments-o"></i>  {{ count($test->comments) }}</span> / <span class=""><i class="fa fa-eye"></i>  {{ $test->view_counts }}</span>
            </div>
        </figure>
        <div class="col-md-8">
            <h4 class="box-title">
                <a href="{{ route('tests.show', $test->slug) }}">{{ $test->name }}</a>
                <small><i class="fa fa-clock-o yellow-color"></i> {{ $test->updated_at }}</small>
            </h4>
            <div class="box-desc">
                {!! (\App\Helpers\Helper::subDescription($test->short_description,'', 500, false)) !!}
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-6 comments-container">
        <div class="comments">
            <h4 class="box-title">Thảo luận: {{ count($test->comments) }} thảo luận</h4>
            <hr>
            @if(count($test->comments) > 0)
                {{--@foreach($test->comments->reverse() as $key => $comment)--}}
                @foreach($test->comments as $key => $comment)
                    <p>
                        <i class="fa fa-comments-o"></i> <b>{{ $comment->user->name }}</b>: {!! Helper::makeLinks(Helper::rip_tags($comment->content),$comment->id, $test->slug, '/de-thi/'.$test->slug) !!}
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