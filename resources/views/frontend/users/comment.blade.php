<div id="comment" class="tab-pane fade comment">
    <div class="filter-section clearfix">
        <form>
            <label class="radio radio-inline">
                <input type="radio" name="filter" checked="checked" value="1"/>
                @lang('messages.frontend_comment_doc')
            </label>
            <label class="radio radio-inline">
                <input type="radio" name="filter" value="2"/>
                @lang('messages.frontend_comment_test')
            </label>
            <label class="radio radio-inline">
                <input type="radio" name="filter" value="3"/>
                @lang('messages.frontend_comment_news')
            </label>
        </form>
    </div>
    <br>
    <div id="docComment">
        @if (count($documents) == 0)
            <div class="header-no-comment">@lang('messages.frontend_no_comment')</div>
        @else
            <table class="table table-bordered">
                <thead>
                <th width="40px" class="text-center">@lang('messages.no')</th>
                <th>@lang('messages.frontend_post')</th>
                </thead>
                <tbody id="doc_comment_list">
                @foreach($documents as $key => $doccument)
                    <tr id="doc_comment_item">
                        <td class="text-center">{!! $key+1 !!}</td>
                        <td><a href="{{ route('documents.show',$doccument->slug) }}"
                               target="_blank">{!! $doccument->name !!}</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @if(count($documents) > 5 )
                <button id="loadMoreDoc"
                        class="btn-large full-width">@lang('messages.frontend_load_more')</button>
            @endif
        @endif
    </div>

    <div id="testComment">
        @if (count($tests) == 0)
            <div class="header-no-comment">@lang('messages.frontend_no_comment')</div>
        @else
            <table class="table table-bordered">
                <thead>
                <th width="40px" class="text-center">@lang('messages.no')</th>
                <th>@lang('messages.frontend_post')</th>
                </thead>
                <tbody id="test_comment_list">
                @foreach($tests as $key => $test)
                    <tr id="test_comment_item">
                        <td class="text-center">{!! $key+1 !!}</td>
                        <td><a href="{{ route('tests.show',$test->slug) }}"
                               target="_blank">{!! $test->name !!}</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @if(count($tests) > 5 )
                <button id="loadMoreTest"
                        class="btn-large full-width">@lang('messages.frontend_load_more')</button>
            @endif
        @endif
    </div>

    <div id="newsComment">
        @if (count($news) == 0)
            <div class="header-no-comment">@lang('messages.frontend_no_comment')</div>
        @else
            <table class="table table-bordered">
                <thead>
                <th width="40px" class="text-center">@lang('messages.no')</th>
                <th>@lang('messages.frontend_post')</th>
                </thead>
                <tbody id="news_comment_list">
                @foreach($news as $key => $new)
                    <tr id="news_comment_item">
                        <td class="text-center">{!! $key+1 !!}</td>
                        <td><a href="{{ route('news.show',$new->slug) }}"
                               target="_blank">{!! $new->name !!}</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @if(count($news) > 5 )
                <button id="loadMoreNews"
                        class="btn-large full-width">@lang('messages.frontend_load_more')</button>
            @endif
        @endif
    </div>
</div>