<table class="table table-bordered">
    <tbody>
    <tr>

        <th style="width: 150px" scope="row">{!! Form::label('name', __('messages.configs_name')) !!}</th>
        <td><p>{!! $config['name'] !!}</p></td>
    </tr>
    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('name', __('messages.configs_value')) !!}</th>
        <td><p>{!! $config['value'] !!}</p></td>
    </tr>
    </tbody>
</table>