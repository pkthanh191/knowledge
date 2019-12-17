<table class="table table-responsive" id="coefficients-table">
    <thead>
    <th width="40px">@lang('messages.no')</th>
    <th>@lang('messages.coefficients_apply_from')</th>
    <th>@lang('messages.coefficients_apply_to')</th>
    <th>@lang('messages.coefficients_cost_from')</th>
    <th>@lang('messages.coefficients_cost_to')</th>
    <th>@lang('messages.coefficient') (VNĐ-> 1 KNOW)</th>
    <th>@lang('messages.coefficients_description')</th>
    <th style="min-width: 110px">@lang('messages.actions')</th>
    </thead>
    <tbody>
    @foreach($coefficients as $index=>$coefficient)
        <tr>
            <td>{!! $index+1 !!}</td>
            <td>{!! $coefficient->apply_from !!}</td>
            <td>{!! $coefficient->apply_to !!}</td>
            <td>{!! $coefficient-> cost_from !=0? \App\Helpers\Helper::format_money($coefficient->cost_from) : '0 VNĐ' !!}</td>
            <td>{!! \App\Helpers\Helper::format_money($coefficient->cost_to) !!}</td>
            <td>{!! $coefficient->coefficient !!}</td>
            <td>{!! $coefficient->description !!}</td>
            <td>
                {!! Form::open(['route' => ['admin.coefficients.destroy', $coefficient->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('admin.coefficients.show', [$coefficient->id]) !!}"
                       class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('admin.coefficients.edit', [$coefficient->id]) !!}"
                       class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('".Lang::get('messages.delete_confirm')."')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>