<table class="table table-responsive" id="courseCategories-table">
    <thead>
        <th>User Id</th>
        <th>Category Course Id</th>
        <th>Course Id</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($courseCategories as $courseCategory)
        <tr>
            <td>{!! $courseCategory->user_id !!}</td>
            <td>{!! $courseCategory->category_course_id !!}</td>
            <td>{!! $courseCategory->course_id !!}</td>
            <td>
                {!! Form::open(['route' => ['admin.courseCategories.destroy', $courseCategory->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('admin.courseCategories.show', [$courseCategory->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('admin.courseCategories.edit', [$courseCategory->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>