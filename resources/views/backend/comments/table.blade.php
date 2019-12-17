<table class="table table-bordered" id="comments-table">
    <thead>
    <th>@lang('messages.no')</th>
    {{--<th><input type="checkbox" name="checkedAll" id="checkedAll" class="minimal checkAll"/></th>--}}
    <th>@lang('messages.comments_document')</th>
    <th>@lang('messages.comments_document_category')</th>
    <th>@lang('messages.comments_user_id')</th>
    <th>@lang('messages.comments_lastest')</th>
    <th>@lang('messages.comments_parent_id')</th>
    <th>@lang('messages.actions')</th>
    </thead>
    <tbody>
    @if(count($documents) == 0)
        <tr class="text-center">
            <td colspan="7">@lang('messages.no-items')</td>
        </tr>
    @else
        @foreach($documents as $key=>$document)
            @if(!empty($document->lastestComment))

                <tr>
                    <td width="1%">{!! ($index++).'.' !!}</td>
                    {{--<td width="40px"><input type="checkbox" name="ids[]" value="{{ $document->lastestComment->id }}"--}}
                                            {{--class="minimal checkSingle" form="items"/></td>--}}
                    <td><a href="{{ route('documents.show',$document->slug) }}" ,
                                         target="_blank">{!! $document->name !!}</a></td>
                    <td>{!! Helper::formatCategories($document->categories) !!}</td>
                    <td>{!! $document->lastestComment->user->name !!}</td>
                    <td style="max-width: 250px;word-wrap: break-word">{!! $document->lastestComment->content !!}</td>
                    <td style="max-width: 250px;word-wrap: break-word">
                        @if($document->lastestComment->parent)
                            {!! $document->lastestComment->parent->content !!}
                        @endif
                    </td>
                    <td width="120px">
                        {!! Form::open(['route' => ['admin.comments.destroy', $document->lastestComment->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{!! route('admin.comments.show', [$document->id]) !!}"
                               class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                            {{--<a href="{!! route('admin.comments.edit', [$document->lastestComment->id]) !!}"--}}
                               {{--class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>--}}
                            {{--{!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('".Lang::get('messages.delete_confirm')."')"]) !!}--}}
                            <button id="{{ $document->lastestComment->id }}" type="button"
                                    class='btn btn-default btn-xs autocomment' data-toggle="modal"
                                    data-target="#myModal"><i class="glyphicon glyphicon-comment"></i></button>
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endif
        @endforeach

        <div id="myModal" class="modal fade" tabindex="-1" role="dialog">
            {!! Form::open(['route' => ['admin.comments.autoComment'], 'method' => 'post']) !!}
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">@lang('messages.comments_modal_title')</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="autoComment" name="id" value="0">
                        {!! Form::text('content', null, ['class' => 'form-control', 'id' => 'content', 'required']) !!}
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i
                                        class="glyphicon glyphicon-remove"></i> @lang('messages.comments_modal_close')
                            </button>
                            <button type="submit" class="btn btn-primary"><i
                                        class="fa fa-save"></i> @lang('messages.comments_modal_save')</button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    @endif
    </tbody>
</table>