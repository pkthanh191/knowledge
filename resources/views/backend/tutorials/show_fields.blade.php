<table class="table table-bordered">
    <tbody>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('name', __('messages.tutorials')) !!}</th>
        <td><p>{!! $tutorial->title !!}</p></td>
    </tr>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('name', __('messages.tutorials_phone')) !!}</th>
        <td><p>{!! $tutorial->phone !!}</p></td>
    </tr>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('name', __('messages.tutorials_email')) !!}</th>
        <td><p>{!! $tutorial->email !!}</p></td>
    </tr>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('name', __('messages.tutorials_subject')) !!}</th>
        <td><p>{!! Helper::formatCategories($tutorial->subjects) !!}</p></td>
    </tr>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('name', __('messages.tutorials_grade')) !!}</th>
        <td><p>{!! Helper::formatCategories($tutorial->grades) !!}</p></td>
    </tr>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('name', __('messages.tutorials_requirement')) !!}</th>
        <td><p>{!! $tutorial->requirement !!}</p></td>
    </tr>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('name', __('messages.tutorials_period')) !!}</th>
        <td><p>{!! $tutorial->period !!}</p></td>
    </tr>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('name', __('messages.tutorials_frequency')) !!}</th>
        <td><p>{!! $tutorial->frequency !!}</p></td>
    </tr>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('name', __('messages.tutorials_salary')) !!}</th>
        <td><p>{!! $tutorial->salary !!}</p></td>
    </tr>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('name', __('messages.tutorials_active')) !!}</th>
        <td>
            <p>
                @if($tutorial->active)
                    {{ __('messages.tutorials_input_active') }}
                @else
                    {{ __('messages.tutorials_input_inactive') }}
                @endif
            </p>
        </td>
    </tr>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('name', __('messages.tutorials_confirm')) !!}</th>
        <td>
            <p>
                @if($tutorial->confirm)
                    {{ __('messages.tutorials_input_confirm') }}
                @else
                    {{ __('messages.tutorials_input_unconfirm') }}
                @endif
            </p>
        </td>
    </tr>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('name', __('messages.meta_title')) !!}</th>
        <td><p>{!! $tutorial->meta_title !!}</p></td>
    </tr>
    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('name', __('messages.meta_keywords')) !!}</th>
        <td><p>{!! $tutorial->meta_keywords !!}</p></td>
    </tr>
    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('name', __('messages.tutorials_address')) !!}</th>
        <td>
            <p>
                @if($tutorial->address)
                    {!! $tutorial->address.', '.$tutorial->district->name.', '.$tutorial->district->city->name !!}
                @else
                    {!! $tutorial->district->name.', '.$tutorial->district->city->name !!}
                @endif
            </p>
        </td>
    </tr>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('created_at', __('messages.created_at')) !!}</th>
        <td><p>{!! $tutorial->created_at !!}</p></td>
    </tr>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('updated_at', __('messages.updated_at')) !!}</th>
        <td><p>{!! $tutorial->updated_at !!}</p></td>
    </tr>

    </tbody>
</table>

