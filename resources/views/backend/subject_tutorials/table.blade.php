<table class="table table-responsive" id="subjectTutorials-table">
    <thead>
        <th>Subject Id</th>
        <th>Tutorial Id</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($subjectTutorials as $subjectTutorial)
        <tr>
            <td>{!! $subjectTutorial->subject_id !!}</td>
            <td>{!! $subjectTutorial->tutorial_id !!}</td>
            <td>
                {!! Form::open(['route' => ['admin.subjectTutorials.destroy', $subjectTutorial->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('admin.subjectTutorials.show', [$subjectTutorial->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('admin.subjectTutorials.edit', [$subjectTutorial->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>