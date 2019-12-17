@if (count($news) == 0)
    <div class="text-center">@lang('messages.frontend-no-item')</div>
@else
    <div class="page">
        <div class="post-content">
            <div class="blog-infinite">
                @foreach($news as $key => $new)
                    @include('frontend._partials.news_list_item')
                @endforeach

                @if($news->hasPages())
                    <div class="box-footer">
                        {!! $news->appends(['search' => Request::get('search')])->render() !!}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endif