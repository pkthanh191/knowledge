<table class="table table-bordered" id="categoryTests-table">
    <thead>
    <th>@lang('messages.no')</th>
    <th><input type="checkbox" name="checkedAll" id="checkedAll"  class="minimal checkAll" /></th>
    <th>@lang('messages.category_test_name')</th>
    <th>@lang('messages.category_test_description')</th>
    <th style="width: 58px">@lang('messages.category_test_orderSort')</th>
    {{--<th class="col-md-2">@lang('messages.category_test_parent_id')<con/th>--}}
    {{--<th>Slug</th>--}}
    <th class="col-md-1" colspan="3">@lang('messages.actions')</th>
    </thead>
    <tbody>
    @if (count($categoryTests) == 0)
        <tr class="text-center">
            <td colspan="5">@lang('messages.no-items')</td>
        </tr>
    @else
        @foreach($categoryTests as $key => $categoryTest)
            <tr>
                <td width="40px">{!! $key +1 !!}</td>
                <td width="40px"><input type="checkbox" name="ids[]" value="{{ $categoryTest->id }}" class="minimal checkSingle" form="items" /></td>
                <td width="250px"><a href="{!! route('admin.categoryTests.show', [$categoryTest->id]) !!}">{!! $categoryTest->name !!}</a></td>
                <td>{!! \App\Helpers\Helper::subDescription($categoryTest->description, route('admin.categoryTests.show', [$categoryTest->id])) !!} </td>
                <td>{{ $categoryTest->orderSort }}</td>
                <td >
                    {!! Form::open(['route' => ['admin.categoryTests.destroy', $categoryTest->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('admin.categoryTests.show', [$categoryTest->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('admin.categoryTests.edit', [$categoryTest->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('".Lang::get('messages.delete_confirm')."')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>


</table>