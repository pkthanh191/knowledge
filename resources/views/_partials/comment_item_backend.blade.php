<li id="{{$comment->id}}" class="comment depth-1 parent-{{ $comment->id }}" value="{{ $comment->id }}">
    <div class="the-comment">
        <div class="avatar">
            @if((!empty($comment->user->avatar)) && file_exists(public_path($comment->user->avatar)))
                <img src="{!! $comment->user->avatar !!}" width="72" height="72" alt="">
            @else
                <img src="/public/uploads/default-avatar.png" width="72" height="72" alt="">
            @endif
        </div>
        <div class="comment-box">
            <div class="comment-author">
                <a class="btn btn-default btn-sm pull-right delete_comment" style="margin-left: 10px;" id="delete_item">@lang('messages.delete')</a>
                <a data-toggle="modal" data-target="#modalEdit" class="btn btn-default btn-sm pull-right" style="margin-left: 10px;" id="edit_item"></i>@lang('messages.edit')</a>
                <a href="#comment"><button class="btn btn-default btn-sm pull-right reply" style="margin-left: 10px;">@lang('messages.frontend-reply')</button></a>
                <a class="btn btn-default btn-sm pull-right reply_count">{{count($comment->child)}} @lang('messages.frontend_reply')</a>
                <h4 class="box-title"><a href="#">{{ $comment->user->name }}</a><small id="timeComment-{{ $comment->id }}">{{ $comment->updated_at }}</small></h4>
            </div>
            <div class="comment-text">
                <p id="content-{{ $comment->id }}">{!! Helper::rip_tags($comment->content) !!}</p>
            </div>
        </div>
    </div>

    @foreach($comment->child as $child)
        <ul class="children-{{ $child->id }}">
            <hr>
            <li id="{{$comment->id}}" class="comment depth-2" value="{{ $child->id }}">
                <div class="the-comment">
                    <div class="avatar">
                        @if((!empty($child->user->avatar)) && file_exists(public_path($child->user->avatar)))
                            <img src="{!! $child->user->avatar !!}" width="72" height="72" alt="">
                        @else
                            <img src="/public/uploads/default-avatar.png" width="72" height="72" alt="">
                        @endif
                    </div>
                    <div class="comment-box">
                        <div class="comment-author">
                            <a class="btn btn-default btn-sm pull-right delete_comment" style="margin-left: 10px;" id="delete_item">@lang('messages.delete')</a>
                            <a data-toggle="modal" data-target="#modalEdit" class="btn btn-default btn-sm pull-right" style="margin-left: 10px;" id="edit_item"></i>@lang('messages.edit')</a>
                            <a href="#comment"><button class="btn btn-default btn-sm pull-right reply" style="margin-left: 10px;">@lang('messages.frontend-reply')</button></a>
                            <h4 class="box-title"><a href="#">{{ $child->user->name }}</a><small id="timeComment-{{ $child->id }}">{{ $child->updated_at }}</small></h4>
                        </div>
                        <div class="comment-text">
                            <p id="content-{{ $child->id }}">{!! Helper::makeLinks(Helper::rip_tags($child->content), null, $slug) !!}</p>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    @endforeach
    <hr>
</li>