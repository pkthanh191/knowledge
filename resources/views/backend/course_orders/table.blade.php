<table class="table table-responsive" id="courseOrders-table">
    <thead>
        <th>Description</th>
        <th>User Id</th>
        <th>Course Id</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($courseOrders as $courseOrder)
        <tr>
            <td>{!! $courseOrder->description !!}</td>
            <td>{!! $courseOrder->user_id !!}</td>
            <td>{!! $courseOrder->course_id !!}</td>
            <td>
                {!! Form::open(['route' => ['admin.courseOrders.destroy', $courseOrder->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('admin.courseOrders.show', [$courseOrder->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('admin.courseOrders.edit', [$courseOrder->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>