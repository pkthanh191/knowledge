<table class="table table-responsive" id="documentMetaValues-table">
    <thead>
        <th>User Id</th>
        <th>Doc Id</th>
        <th>Doc Meta Id</th>
        <th>Value</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($documentMetaValues as $documentMetaValue)
        <tr>
            <td>{!! $documentMetaValue->user_id !!}</td>
            <td>{!! $documentMetaValue->doc_id !!}</td>
            <td>{!! $documentMetaValue->doc_meta_id !!}</td>
            <td>{!! $documentMetaValue->value !!}</td>
            <td>
                {!! Form::open(['route' => ['admin.documentMetaValues.destroy', $documentMetaValue->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('admin.documentMetaValues.show', [$documentMetaValue->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('admin.documentMetaValues.edit', [$documentMetaValue->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>