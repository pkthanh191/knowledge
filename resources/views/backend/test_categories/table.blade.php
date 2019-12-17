<table class="table table-responsive" id="testCategories-table">
    <thead>
        <th>User Id</th>
        <th>Category Test Id</th>
        <th>Test Id</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($testCategories as $testCategory)
        <tr>
            <td>{!! $testCategory->user_id !!}</td>
            <td>{!! $testCategory->category_test_id !!}</td>
            <td>{!! $testCategory->test_id !!}</td>
            <td>
                {!! Form::open(['route' => ['admin.testCategories.destroy', $testCategory->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('admin.testCategories.show', [$testCategory->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('admin.testCategories.edit', [$testCategory->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>