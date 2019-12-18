<li id="{{$comment->id}}" class="comment depth-1">
    <div class="the-comment">
        <div class="avatar">
            @if((!empty($comment->user->avatar)) && file_exists(public_path($comment->user->avatar)))
                <img data-original="{!! $comment->user->avatar !!}" width="72" height="72" alt="">
            @else
                <img data-original="/public/uploads/default-avatar.png" width="72" height="72" alt="">
            @endif
        </div>
        <div class="comment-box">
            <div class="comment-author">
                @if(Auth::check())<button type="button" style="margin-left: 10px;" class="button btn-mini pull-right reply">@lang('messages.frontend-reply')</button>@endif
                <a class="button btn-mini pull-right reply_count">{{count($comment->child)}} @lang('messages.frontend_reply')</a>
                <h4 class="box-title"><a href="#">{{ $comment->user->name }}</a><small>{{ $comment->updated_at }}</small></h4>
            </div>
            <div class="comment-text">
                <p>{!! Helper::makeLinks(Helper::rip_tags($comment->content),$comment->id, $slug) !!}</p>
            </div>
        </div>
    </div>

    @foreach($comment->child as $child)
        <ul class="children">
            <li id="{{$comment->id}}" class="comment depth-2">
                <div class="the-comment">
                    <div class="avatar">
                        @if((!empty($child->user->avatar)) && file_exists(public_path($child->user->avatar)))
                            <img data-original="{!! $child->user->avatar !!}" width="72" height="72" alt="">
                        @else
                            <img data-original="/public/uploads/default-avatar.png" width="72" height="72" alt="">
                        @endif
                    </div>
                    <div class="comment-box">
                        <div class="comment-author">
                            @if(Auth::check())<button type="button" class="button btn-mini pull-right reply">@lang('messages.frontend-reply')</button>@endif
                            <h4 class="box-title"><a href="#">{{ $child->user->name }}</a><small>{{ $child->updated_at }}</small></h4>
                        </div>
                        <div class="comment-text">
                            <p>{!! Helper::makeLinks(Helper::rip_tags($child->content), $child->id, $slug) !!}</p>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    @endforeach

</li>