<div class="comments-container block">
    <div class="page-header"><h4>@lang('messages.test'): {{ $test->name }}</h4>
    </div>
    <h4 id="comment_count">{{ $commentCount }} @lang('messages.frontend-comments')</h4>
    <ul id="comment_list" class="comment-list travelo-box">
        @if (count($test->comments) == 0)
            <div id="no-comment">@lang('messages.frontend-no-comments')</div>
        @else
            @foreach($test->comments as $key => $comment)
                @include('_partials.comment_item_backend')
            @endforeach
            @if(count($test->comments) > 5 )
                <button id="loadMore" class="btn btn-default">@lang('messages.frontend_load_more_comment')</button>
            @endif
        @endif
    </ul>
</div>

<form id="formDelete">
    {{ csrf_field() }}
    <input type="hidden" id="slug" name="slug" value="{{ $test->slug }}">
    <input type="hidden" id="parent_id_delete" name="parent_id" value="0">
</form>

<div id="modalEdit" class="modal fade" tabindex="-1" role="dialog">
    <form id="editForm">
        {{ csrf_field() }}
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">@lang('messages.comments_edit_modal_title')</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editComment" name="id" value="0">
                    <input type="text" class="form-control" id="content" name="content">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i
                                    class="glyphicon glyphicon-remove"></i> @lang('messages.comments_modal_close')
                        </button>
                        <button type="submit" class="btn btn-primary"><i
                                    class="fa fa-save"></i> @lang('messages.comments_modal_save')</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="post-comment block">
    <h4 class="reply-title">@lang('messages.frontend-post-comment')</h4>
    <div class="travelo-box">
        <form class="comment-form" id="comment">

            <div class="form-group">
                <label>@lang('messages.frontend-comment-message')</label>
                <textarea id="content" name="content" rows="6" class="input-text full-width"
                          placeholder="@lang('messages.frontend-comment-message-placeholder')"></textarea>
            </div>
            {{ csrf_field() }}
            <input type="hidden" id="slug" name="slug" value="{{ $test->slug }}">
            <input type="hidden" id="parent_id" name="parent_id" value="0">

            <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-comment"></i> @lang('messages.frontend-comment-submit')</button>
            <a href="{!! route('admin.commentTests.index') !!}" class="btn btn-default"><i
                        class="fa fa-mail-reply"></i> @lang('messages.back')</a>
        </form>
    </div>
</div>