<table class="table table-responsive" id="gradeTutorials-table">
    <thead>
        <th>Grade Id</th>
        <th>Tutorial Id</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($gradeTutorials as $gradeTutorial)
        <tr>
            <td>{!! $gradeTutorial->grade_id !!}</td>
            <td>{!! $gradeTutorial->tutorial_id !!}</td>
            <td>
                {!! Form::open(['route' => ['admin.gradeTutorials.destroy', $gradeTutorial->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('admin.gradeTutorials.show', [$gradeTutorial->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('admin.gradeTutorials.edit', [$gradeTutorial->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>