<table class="table table-bordered">
    <tbody>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('name', __('messages.static_pages_name')) !!}</th>
        <td><p>{!! $page->name !!}</p></td>
    </tr>


    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('description', __('messages.static_pages_description')) !!}</th>
        <td><p>{!! $page->description  !!}</p></td>
    </tr>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('created_at', __('messages.created_at')) !!}</th>
        <td><p>{!! $page->created_at !!}</p></td>
    </tr>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('updated_at', __('messages.updated_at')) !!}</th>
        <td><p>{!! $page->updated_at !!}</p></td>
    </tr>

    </tbody>
</table>


