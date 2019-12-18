<div class="post">
    <div class="post-content-wrapper" style="background: #fff; padding: 10px;">
        <div class="row">
            <div class="col-md-4">
                <figure class="image-container">
                    <a href="{{ route('news.show', $new->slug) }}" class=""><img class="news-img" data-original="/public/{{ $new->image }}" alt="{{ $new->slug }}" /></a>
                </figure>
            </div>

            <div class="col-md-8">
                <div class="details" style="background: none;  padding: 0px;">
                    <h3 class="entry-title"><a href="{{ route('news.show',$new->slug) }}">{{ $new->name }}</a></h3>
                    <div class="excerpt-container">
                        <div class="text-justify">{!! $new->short_description !!}</div>
                    </div>
                    <div class="text-right">
                        {{--<div class="entry-date">
                            <label class="date">{{ $new->created_at->format('d') }}</label>
                            <label class="month">Tháng {{ $new->created_at->format('m') }}</label>
                        </div>--}}
                        Ngày đăng: {{ $new->created_at->format('d/m/Y') }}
                        {{--<a href="{{ route('news.show', $new->slug) }}" class="button btn-small text-center"> @lang('messages.frontend-readmore')</a>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>