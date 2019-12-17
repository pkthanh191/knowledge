<table class="table table-bordered">
    <tbody>
    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('name', __('messages.document_name')) !!}</th>
        <td><p>{!! $document->name !!}</p></td>
    </tr>
    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('file', __('messages.document_file')) !!}</th>
        <td><p>{!! $document->file !!}</p></td>
    </tr>
    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('file', __('messages.document_short_file')) !!}</th>
        <td><p>{!! $document->short_file !!}</p></td>
    </tr>
    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('link_download', __('messages.document_link_download')) !!}</th>
        <td><p>{!! $document->link_download !!}</p></td>
    </tr>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('category', __('messages.document_category')) !!}</th>
        <td>{!! Helper::formatCategories($document->categories) !!}</td>
    </tr>

    @foreach($documentMetaValues as $documentMetaValue)
        <tr>
            <th style="width: 150px" scope="row">{!! Form::label( $documentMetaValue->documentMeta->name ) !!}</th>
            <td><p>{!! $documentMetaValue->value !!}</p></td>
        </tr>
    @endforeach

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('image', __('messages.document_image')) !!}</th>
        <td><p><img src="{!! asset($document->image) !!}" style="height: 200px"></p></td>
    </tr>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('description', __('messages.document_description')) !!}</th>
        <td><p>{!! $document->description !!}</p></td>
    </tr>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('slug', __('messages.document_slug')) !!}</th>
        <td><p>{!! $document->slug !!}</p></td>
    </tr>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('comment_counts', __('messages.document_comment_counts')) !!}</th>
        <td><p>{!! $document->comment_counts !!}</p></td>
    </tr>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('view_counts', __('messages.document_view_counts')) !!}</th>
        <td><p>{!! $document->view_counts !!}</p></td>
    </tr>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('created_at', __('messages.created_at')) !!}</th>
        <td><p>{!! $document->created_at !!}</p></td>
    </tr>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('updated_at', __('messages.updated_at')) !!}</th>
        <td><p>{!! $document->updated_at !!}</p></td>
    </tr>
    </tbody>
</table>