<table class="table table-bordered" id="transactions-table">
    <thead>
    <th width="40px">@lang('messages.no')</th>
    <th><input type="checkbox" name="checkedAll" id="checkedAll"  class="minimal checkAll" /></th>
    <th>@lang('messages.transactions_user')</th>
    <th>@lang('messages.transactions_money')</th>
    <th>@lang('messages.transactions_date')</th>
    <th>@lang('messages.transactions_content')</th>
    <th>@lang('messages.transactions_status')</th>
    <th colspan="3" class="col-md-1">@lang('messages.actions')</th>
    </thead>
    <tbody>
    @foreach($transactions as $key => $transaction)
        <tr>
            <td>{!! Helper::number_order($transactions->currentPage(),$transactions->perPage(),$key) !!}</td>
            <td width="40px"><input type="checkbox" name="ids[]" value="{{ $transaction->id }}" class="minimal checkSingle" form="items"/></td>
            <td>{!! $transaction->user? $transaction->user->name : '' !!}</td>
            <td>{!! ($transaction->content < 3 || $transaction->content == 8 )? '+'.Helper::format_money($transaction->money_transfer,true,' KNOW') : '-'.Helper::format_money($transaction->money_transfer,true,' KNOW')!!}</td>
            <td>{!! $transaction->created_at !!}</td>
            <td>{!! Helper::convertTransFields('content',$transaction->content) !!}</td>
            <td>{!! Helper::convertTransaction($transaction->status) !!}</td>
            <td>
                {!! Form::open(['route' => ['admin.transactions.destroy', $transaction->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('admin.transactions.show', [$transaction->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    {{--<a href="{!! route('admin.transactions.edit', [$transaction->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>--}}
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('".Lang::get('messages.delete_confirm')."')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>