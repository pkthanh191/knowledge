<table class="table table-responsive" id="documentCategories-table">
    <thead>
        <th>User Id</th>
        <th>Category Id</th>
        <th>Document Id</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($documentCategories as $documentCategory)
        <tr>
            <td>{!! $documentCategory->user_id !!}</td>
            <td>{!! $documentCategory->category_id !!}</td>
            <td>{!! $documentCategory->document_id !!}</td>
            <td>
                {!! Form::open(['route' => ['admin.documentCategories.destroy', $documentCategory->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('admin.documentCategories.show', [$documentCategory->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('admin.documentCategories.edit', [$documentCategory->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>