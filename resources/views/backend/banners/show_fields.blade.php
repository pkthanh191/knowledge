<table class="table table-bordered">
    <tbody>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('name', __('messages.banner_name')) !!}</th>
        <td><p>{!! $banner->name !!}</p></td>
    </tr>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('image', __('messages.banner_image')) !!}</th>
        <td><p><img src="{!! $banner->image !!}" height="200px"></p></td>
    </tr>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('url', __('messages.banner_url')) !!}</th>
        <td><p>{!! $banner->url !!}</p></td>
    </tr>

    <tr>
        <th style="width: 150px"
            scope="row">{!! Form::label('description', __('messages.banner_description')) !!}</th>
        <td><p>{!! $banner->description !!}</p></td>
    </tr>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('position', __('messages.banner_position')) !!}</th>
        <td>{!! Helper::convertPosition($banner->position) !!}</td>
    </tr>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('status', __('messages.banner_status')) !!}</th>
        <td>{!! Helper::convertActived($banner->status) !!}</td>
    </tr>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('created_at', __('messages.created_at')) !!}</th>
        <td><p>{!! $banner->created_at !!}</p></td>
    </tr>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('updated_at', __('messages.updated_at')) !!}</th>
        <td><p>{!! $banner->updated_at !!}</p></td>
    </tr>

    </tbody>
</table>
