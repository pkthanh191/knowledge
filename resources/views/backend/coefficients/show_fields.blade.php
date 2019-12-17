<table class="table table-bordered">
    <tbody>
    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('apply_to', __('messages.coefficients_apply_from')) !!}</th>
        <th><p>{!! $coefficient->apply_from !!}</p></th>
    </tr>
    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('apply_to', __('messages.coefficients_apply_to')) !!}</th>
        <th><p>{!! $coefficient->apply_to !!}</p></th>
    </tr>
    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('cost_form', __('messages.coefficients_cost_from')) !!}</th>
        <td><p>{!! $coefficient->cost_from !!}</p></td>
    </tr>
    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('cost_form', __('messages.coefficients_cost_to')) !!}</th>
        <td><p>{!! $coefficient->cost_to !!}</p></td>
    </tr>
    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('coefficient', __('messages.coefficient')) !!}</th>
        <td><p>{!! $coefficient->coefficient !!}</p></td>
    </tr>
    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('description', __('messages.coefficients_description')) !!}</th>
        <td><p>{!! $coefficient->description !!}</p></td>
    </tr>
    </tbody>
</table>

