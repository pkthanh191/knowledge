<table class="table table-bordered">
    <tbody>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('name', __('messages.document_metas_name')) !!}</th>
        <td><p>{!! $documentMeta->name !!}</p></td>
    </tr>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('description', __('messages.document_metas_description')) !!}</th>
        <td><p>{!! $documentMeta->description !!}</p></td>
    </tr>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('category_doc_meta_id', __('messages.document_metas_category_doc_meta')) !!}</th>
        <td><p>{!! $documentMeta->categoryDocMeta->name !!}</p></td>
    </tr>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('created_at', __('messages.created_at')) !!}</th>
        <td><p>{!! $documentMeta->created_at !!}</p></td>
    </tr>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('updated_at', __('messages.updated_at')) !!}</th>
        <td><p>{!! $documentMeta->updated_at !!}</p></td>
    </tr>

    </tbody>
</table>
