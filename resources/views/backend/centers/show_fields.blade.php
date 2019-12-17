<table class="table table-bordered">
    <tbody>
    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('name', __('messages.center_name')) !!}</th>
        <td><p>{!! $center->name !!}</p></td>
    </tr>
    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('description', __('messages.center_description')) !!}</th>
        <td><p>{!! $center->description !!}</p></td>
    </tr>
    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('address', __('messages.center_address')) !!}</th>
        <td><p>{!! $center->address !!}</p></td>
    </tr>
    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('phone', __('messages.center_phone')) !!}</th>
        <td><p>{!! $center->phone !!}</p></td>
    </tr>
    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('email', __('messages.center_email')) !!}</th>
        <td><p>{!! $center->email !!}</p></td>
    </tr>
    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('image', __('messages.center_image')) !!}</th>
        <th>
            @if((!empty($center->image)) && file_exists(public_path($center->image)))
                <img src="{!! $center->image !!}" alt="{!! $center->name !!}" height="200px" >
            @else
                <img src="" alt="{!! $center->name !!}" height="200px">
            @endif

        </th>
    </tr>
    </tbody>
</table>
