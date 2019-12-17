<div class="toggle-container filters-container">
    <div class="panel style1 arrow-right">
        <h4 class="panel-title">
            <a data-toggle="collapse" href="#test-categories-filter" class="">@lang('messages.frontend-test-categories')</a>
        </h4>
        <div id="test-categories-filter" class="panel-collapse collapse in">
            <div class="panel-content">
                <ul class="filters-option">
                    <li @if($categorySlug == null && $type == 'tests') class="active" @endif><a href="{{ route('tests') }}">@lang('messages.frontend-all')<small>({{$testCount}})</small></a></li>
                    @foreach($testCategories as $key => $category)
                        <li @if($categorySlug == $category->slug && $type == 'tests') class="active" @endif><a href="{{ route('tests') }}?danh-muc={{ $category->slug }}">{{ $category->name }}<small>({{ count($category->test) }})</small></a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <div class="panel style1 arrow-right">
        <h4 class="panel-title">
            <a data-toggle="collapse" href="#doc-categories-filter" class="">@lang('messages.frontend-doc-categories')</a>
        </h4>
        <div id="doc-categories-filter" class="panel-collapse collapse in">
            <div class="panel-content">
                <ul class="filters-option">
                    <li @if($categorySlug == null && $type == 'documents') class="active" @endif><a href="{{ route('tests') }}">@lang('messages.frontend-all')<small>({{$documentCount}})</small></a></li>
                    @foreach($docCategories as $key => $category)
                        <li @if($categorySlug == $category->slug && $type == 'documents') class="active" @endif><a href="{{ route('documents') }}?danh-muc={{ $category->slug }}">{{ $category->name }}<small>({{ count($category->test) }})</small></a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <div class="panel style1 arrow-right">
        <h4 class="panel-title">
            <a data-toggle="collapse" href="#center-categories-filter" class="">@lang('messages.frontend-center-categories')</a>
        </h4>
        <div id="center-categories-filter" class="panel-collapse collapse in">
            <div class="panel-content">
                <ul class="filters-option">
                    <li @if($type == 'centers') class="active" @endif><a href="{{ route('centers') }}">@lang('messages.frontend-centers')<small>({{$centerCount}})</small></a></li>
                    <li @if($type == 'teachers') class="active" @endif><a href="{{ route('teachers') }}">@lang('messages.frontend-teachers')<small>({{$teacherCount}})</small></a></li>
                    <li @if($type == 'courses') class="active" @endif><a href="{{ route('courses') }}">@lang('messages.frontend-courses')<small>({{$courseCount}})</small></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>