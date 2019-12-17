<table class="table table-bordered">
    <tbody>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('name', __('messages.category_doc_metas_name')) !!}</th>
        <td><p>{!! $categoryDocMeta->name !!}</p></td>
    </tr>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('description', __('messages.category_doc_metas_description')) !!}</th>
        <td><p>{!! $categoryDocMeta->description !!}</p></td>
    </tr>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('description', __('messages.slug')) !!}</th>
        <td><p>{!! $categoryDocMeta->slug !!}</p></td>
    </tr>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('created_at', __('messages.created_at')) !!}</th>
        <td><p>{!! $categoryDocMeta->created_at !!}</p></td>
    </tr>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('updated_at', __('messages.updated_at')) !!}</th>
        <td><p>{!! $categoryDocMeta->updated_at !!}</p></td>
    </tr>

    </tbody>
</table>
