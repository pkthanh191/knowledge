<table class="table table-bordered" id="categoryDocs-table">
    <thead>
    <th>@lang('messages.no')</th>
    <th><input type="checkbox" name="checkedAll" id="checkedAll"  class="minimal checkAll" /></th>
    <th>@lang('messages.category_doc_metas_name')</th>
    <th>@lang('messages.category_doc_metas_description')</th>
    <th>@lang('messages.slug')</th>
    <th colspan="3">@lang('messages.actions')</th>
    </thead>
    <tbody>
        @if (count($categoryDocMetas) == 0)
            <tr class="text-center">
                <td colspan="6">@lang('messages.no-items')</td>
            </tr>
        @else
            @foreach($categoryDocMetas as $key => $categoryDocMeta)
                <tr>
                    <td width="40px">{!! Helper::number_order($categoryDocMetas->currentPage(), $categoryDocMetas->perPage(), $key)!!}</td>
                    <td width="40px"><input type="checkbox" name="ids[]" value="{{ $categoryDocMeta->id }}" class="minimal checkSingle" form="items"/></td>
                    <td width="250px"><a href="{!! route('admin.categoryDocMetas.show', [$categoryDocMeta->id]) !!}">{!! $categoryDocMeta->name !!}</a></td>
                    <td>{!! Helper::subDescription($categoryDocMeta->description, route('admin.categoryDocMetas.show', [$categoryDocMeta->id])) !!}</td>
                    <td>{!! $categoryDocMeta->slug !!}</td>
                    <td width="100px">
                        {!! Form::open(['route' => ['admin.categoryDocMetas.destroy', $categoryDocMeta->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{!! route('admin.categoryDocMetas.show', [$categoryDocMeta->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                            <a href="{!! route('admin.categoryDocMetas.edit', [$categoryDocMeta->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                            {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('".Lang::get('messages.delete_confirm')."')"]) !!}
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>