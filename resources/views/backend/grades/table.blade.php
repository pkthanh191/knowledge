<table class="table table-bordered" id="subjects-table">
    <thead>
    <th width="40px">@lang('messages.no')</th>
    <th width="40px"><input type="checkbox" name="checkedAll" id="checkedAll"  class="minimal checkAll" /></th>
    <th>@lang('messages.grades_name')</th>
    <th colspan="4" class="col-md-1">@lang('messages.actions')</th>
    </thead>
    <tbody>
    @if (count($grades) == 0)
        <tr class="text-center">
            <td colspan="4">@lang('messages.no-items')</td>
        </tr>
    @else
        @foreach($grades as $key=>$grade)
            <tr>
                <td width="40px">{!! Helper::number_order($grades->currentPage(), $grades->perPage(), $key) !!}</td>
                <td><input type="checkbox" name="ids[]" value="{{ $grade->id }}" class="minimal checkSingle" form="items"/></td>
                <td>{!! $grade->name !!}</td>
                <td>
                    {!! Form::open(['route' => ['admin.grades.destroy', $grade->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('admin.grades.show', [$grade->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('admin.grades.edit', [$grade->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('".Lang::get('messages.delete_confirm')."')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>