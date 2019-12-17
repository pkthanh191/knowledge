<table class="table table-bordered" id="categoryDocs-table">
    <thead>
        <th>@lang('messages.no')</th>
        <th><input type="checkbox" name="checkedAll" id="checkedAll"  class="minimal checkAll" /></th>
        <th>@lang('messages.category_doc_name')</th>
        <th>@lang('messages.category_doc_description')</th>
        <th style="width: 58px">@lang('messages.category_doc_orderSort')</th>
        <th colspan="3">@lang('messages.actions')</th>
    </thead>
    <tbody>
        @if (count($categoryDocs) == 0)
            <tr class="text-center">
                <td colspan="6">@lang('messages.no-items')</td>
            </tr>
        @else
            @foreach($categoryDocs as $key => $categoryDoc)
                <tr>
                    <td width="40px">{!! ($key+1).'.' !!}</td>
                    <td width="40px"><input type="checkbox" name="ids[]" value="{{ $categoryDoc->id }}" class="minimal checkSingle" form="items" /></td>
                    <td width="250px"><a href="{!! route('admin.categoryDocs.show', [$categoryDoc->id]) !!}">{!! $categoryDoc->name !!}</a></td>
                    <td>{!! Helper::subDescription($categoryDoc->description, route('admin.categoryDocs.show', [$categoryDoc->id])) !!} </td>
                    <td>{{ $categoryDoc->orderSort }}</td>
                    <td width="100px">
                        {!! Form::open(['route' => ['admin.categoryDocs.destroy', $categoryDoc->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{!! route('admin.categoryDocs.show', [$categoryDoc->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                            <a href="{!! route('admin.categoryDocs.edit', [$categoryDoc->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                            {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('".Lang::get('messages.delete_confirm')."')"]) !!}
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>