<table class="table table-bordered" id="documents-table">
    <thead>
        <th>@lang('messages.no')</th>
        <th><input type="checkbox" name="checkedAll" id="checkedAll"  class="minimal checkAll" /></th>
        <th>@lang('messages.document_name')</th>
        <th>@lang('messages.document_category')</th>
        <th>@lang('messages.document_comment_counts')</th>
        <th>@lang('messages.document_view_counts')</th>
        <th>@lang('messages.document_image')</th>
        <th colspan="3">@lang('messages.actions')</th>
    </thead>
    <tbody>
    @if (count($documents) == 0)
        <tr class="text-center">
            <td colspan="9">@lang('messages.no-items')</td>
        </tr>
    @else
        @foreach($documents as $index => $document)
            <tr>
                <td width="40px">{!! Helper::number_order($documents->currentPage(), $documents->perPage(), $index) !!}</td>
                <td width="40px"><input type="checkbox" name="ids[]" value="{{ $document->id }}" class="minimal checkSingle" form="items"/></td>
                <td width="250px"><a href="{!! route('admin.documents.show', [$document->id]) !!}">{!! $document->name !!}</a></td>
                <td width="200px">{!! Helper::formatCategories($document->categories,"<br>") !!}</td>
                <td width="130px">{!! $document->comment_counts !!}</td>
                <td width="100px">{!! $document->view_counts !!}</td>
                <td width="40px"><img src="{!! asset('/public/'.$document->image) !!}" style="width: 100px; height: 100px"></td>
                <td width="100px">
                    {!! Form::open(['route' => ['admin.documents.destroy', $document->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('admin.documents.show', [$document->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('admin.documents.edit', [$document->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('".Lang::get('messages.delete_confirm')."')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>
