<table class="table table-bordered" id="subjects-table">
    <thead>
        <th width="40px">@lang('messages.no')</th>
        <th width="40px"><input type="checkbox" name="checkedAll" id="checkedAll"  class="minimal checkAll" /></th>
        <th>@lang('messages.subjects')</th>
        <th colspan="3" class="col-md-1">@lang('messages.actions')</th>
    </thead>
    <tbody>
    @if (count($subjects) == 0)
        <tr class="text-center">
            <td colspan="4">@lang('messages.no-items')</td>
        </tr>
    @else
        @foreach($subjects as $key=>$subject)
            <tr>
                <td width="40px">{!! Helper::number_order($subjects->currentPage(), $subjects->perPage(), $key) !!}</td>
                <td><input type="checkbox" name="ids[]" value="{{ $subject->id }}" class="minimal checkSingle" form="items"/></td>
                <td>{!! $subject->name !!}</td>
                <td>
                    {!! Form::open(['route' => ['admin.subjects.destroy', $subject->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('admin.subjects.show', [$subject->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('admin.subjects.edit', [$subject->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('".Lang::get('messages.delete_confirm')."')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
     @endif
    </tbody>
</table>