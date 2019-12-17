<table class="table table-bordered">
    <tbody>

    <tr>
        <th style="width: 250px"
            scope="row">{!! Form::label('money_transfer', __('messages.transactions_money')) !!}</th>
        <td><p>{!! ($transaction->content < 3 || $transaction->content == 8 )? '+'.Helper::format_money($transaction->money_transfer,true,' KNOW') : '-'.Helper::format_money($transaction->money_transfer,true,' KNOW') !!}</p></td>
    </tr>

    <tr>
        <th style="width: 250px" scope="row">{!! Form::label('created_at', __('messages.transactions_date')) !!}</th>
        <td><p>{!! $transaction->created_at !!}</p></td>
    </tr>

    <tr>
        <th style="width: 250px"
            scope="row">{!! Form::label('content', __('messages.transactions_content')) !!}</th>
        <td><p>{!! Helper::convertTransFields('content',$transaction->content) !!}</p></td>
    </tr>

    <tr>
        <th style="width: 250px" scope="row">{!! Form::label('status', __('messages.transactions_status')) !!}</th>
        <td>{!! Helper::convertTransaction($transaction->status) !!}</td>
    </tr>

    @if($transaction->content == 1)
        <tr>
            <th style="width: 250px" scope="row">{!! Form::label('trans_id', __('messages.transactions_nl_id')) !!}</th>
            <td>{!! $transaction->trans_id !!}</td>
        </tr>
        <tr>
            <th style="width: 250px" scope="row">{!! Form::label('trans_type', __('messages.transactions_nl_type')) !!}</th>
            <td>{!! Helper::convertTransFields('type',$transaction->trans_type) !!}</td>
        </tr>
        <tr>
            <th style="width: 250px" scope="row">{!! Form::label('trans_status', __('messages.transactions_nl_status')) !!}</th>
            <td>{!! Helper::convertTransFields('nl_status',$transaction->trans_status) !!}</td>
        </tr>
        <tr>
            <th style="width: 250px" scope="row">{!! Form::label('trans_email', __('messages.transactions_nl_email')) !!}</th>
            <td>{!! $transaction->trans_email !!}</td>
        </tr>
        <tr>
            <th style="width: 250px" scope="row">{!! Form::label('trans_phone', __('messages.transactions_nl_phone')) !!}</th>
            <td>{!! $transaction->trans_phone !!}</td>
        </tr>
        <tr>
            <th style="width: 250px" scope="row">{!! Form::label('trans_payment_name', __('messages.transactions_payment_name')) !!}</th>
            <td>{!! $transaction->trans_payment_name !!}</td>
        </tr>
        <tr>
            <th style="width: 250px" scope="row">{!! Form::label('trans_fee', __('messages.transactions_fee')) !!}</th>
            <td>{!! $transaction->trans_fee !!}</td>
        </tr>

    @endif
    <tr>
        <th style="width: 250px" scope="row">{!! Form::label('created_at', __('messages.created_at')) !!}</th>
        <td><p>{!! $transaction->created_at->format('d-m-Y') !!}</p></td>
    </tr>

    <tr>
        <th style="width: 250px" scope="row">{!! Form::label('updated_at', __('messages.updated_at')) !!}</th>
        <td><p>{!! $transaction->updated_at->format('d-m-Y') !!}</p></td>
    </tr>

    </tbody>
</table>