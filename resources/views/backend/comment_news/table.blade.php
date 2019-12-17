<table class="table table-bordered" id="comment-news-table">
    <thead>
    <th>@lang('messages.no')</th>
    {{--<th><input type="checkbox" name="checkedAll" id="checkedAll"  class="minimal checkAll" /></th>--}}
    <th>@lang('messages.news')</th>
    <th>@lang('messages.comments_news_category')</th>
    <th>@lang('messages.comment_tests_user_id')</th>
    <th>@lang('messages.comment_news_lastest')</th>
    <th>@lang('messages.comment_news_parent_id')</th>
    <th colspan="2">@lang('messages.actions')</th>
    </thead>
    <tbody>
    @if(count($news) == 0)
        <tr class="text-center">
            <td colspan="7">@lang('messages.no-items')</td>
        </tr>
    @else
        @foreach($news as $key=>$new)
            @if(!empty($new->lastestComment))

                <tr>
                    <td width="40px">{!! ($index++).'.' !!}</td>
                    {{--<td width="40px"><input type="checkbox" name="ids[]" value="{{ $new->lastestComment->id }}" class="minimal checkSingle" form="items"/></td>--}}
                    <td width="120px"><a href="{{ route('news.show',$new->slug) }}", target="_blank">{!! $new->name !!}</a></td>
                    <td width="200px">{!! Helper::formatCategories($new->categories) !!}</td><td width="120px">{!! $new->lastestComment->user->name !!}</td>
                    <td style="max-width: 250px;word-wrap: break-word">{!! $new->lastestComment->content !!}</td>
                    <td style="max-width: 250px;word-wrap: break-word">
                        @if($new->lastestComment->parent)
                            {!! $new->lastestComment->parent->content !!}
                        @endif
                    </td>
                    <td width="120px">
                        {!! Form::open(['route' => ['admin.commentNews.destroy', $new->lastestComment->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{!! route('admin.commentNews.show', [$new->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                            {{--<a href="{!! route('admin.commentNews.edit', [$new->lastestComment->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>--}}
                            {{--{!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('".Lang::get('messages.delete_confirm')."')"]) !!}--}}
                            <button id="{{ $new->lastestComment->id }}" type="button" class='btn btn-default btn-xs autocomment' data-toggle="modal" data-target="#myModal"><i class="glyphicon glyphicon-comment"></i></button>
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endif
        @endforeach

        <div id="myModal" class="modal fade" tabindex="-1" role="dialog">
            {!! Form::open(['route' => ['admin.commentNews.autoComment'], 'method' => 'post']) !!}
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">@lang('messages.comments_modal_title')</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="autoComment" name="id" value="0">
                        {!! Form::text('content', null, ['class' => 'form-control', 'id' => 'content', 'required']) !!}
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> @lang('messages.comments_modal_close')</button>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> @lang('messages.comments_modal_save')</button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    @endif
    </tbody>
</table>