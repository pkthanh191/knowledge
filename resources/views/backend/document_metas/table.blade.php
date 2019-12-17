<table class="table table-bordered" id="categoryDocs-table">
    <thead>
    <th>@lang('messages.no')</th>
    <th><input type="checkbox" name="checkedAll" id="checkedAll"  class="minimal checkAll" /></th>
    <th>@lang('messages.document_metas_name')</th>
    <th>@lang('messages.document_metas_description')</th>
    <th>@lang('messages.document_metas_category_doc_meta')</th>
    <th>@lang('messages.document_metas_orderSort')</th>
    <th colspan="3">@lang('messages.actions')</th>
    </thead>
    <tbody>
    @if (count($documentMetas) == 0)
        <tr class="text-center">
            <td colspan="6">@lang('messages.no-items')</td>
        </tr>
    @else
        @foreach($documentMetas as $key => $documentMeta)
            <tr>
                <td width="40px">{!! Helper::number_order($documentMetas->currentPage(), $documentMetas->perPage(), $key) !!}</td>
                <td width="40px"><input type="checkbox" name="ids[]" value="{{ $documentMeta->id }}" class="minimal checkSingle" form="items"/></td>
                <td width="250px"><a href="{!! route('admin.documentMetas.show', [$documentMeta->id]) !!}">{!! $documentMeta->name !!}</a></td>
                <td>{!! Helper::subDescription($documentMeta->description, route('admin.documentMetas.show', [$documentMeta->id])) !!}</td>
                <td>{!! $documentMeta->categoryDocMeta->name !!}</td>
                <td style="width: 58px">{{ $documentMeta->orderSort }}</td>
                <td width="100px">
                    {!! Form::open(['route' => ['admin.documentMetas.destroy', $documentMeta->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('admin.documentMetas.show', [$documentMeta->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('admin.documentMetas.edit', [$documentMeta->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('".Lang::get('messages.delete_confirm')."')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>