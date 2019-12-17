<div class="toggle-container filters-container">
    <div class="panel style1 arrow-right">
        <h4 class="panel-title">
            <a data-toggle="collapse" href="#news-categories-filter" class="">@lang('messages.frontend-news')</a>
        </h4>
        <div id="news-categories-filter" class="panel-collapse collapse in">
            <div class="panel-content">
                <ul class="filters-option">
                    <li @if($categorySlug == null && $type == 'news' && empty($newsIndex->slug)) class="active" @endif><a href="{{ route('news') }}">@lang('messages.frontend-all')<small>{{ count($allNews) }}</small></a></li>
                    @foreach($newsCategories as $key => $category)
                        <li @if($categorySlug == $category->slug && $type == 'news') class="active" @endif><a href="{{ route('news') }}?danh-muc={{ $category->slug }}">{{ $category->name }}<small>({{ count($category->news) }})</small></a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>