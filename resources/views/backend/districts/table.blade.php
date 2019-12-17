<table class="table table-responsive" id="districts-table">
    <thead>
        <th>Code</th>
        <th>Name</th>
        <th>Type</th>
        <th>Code City</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($districts as $district)
        <tr>
            <td>{!! $district->code !!}</td>
            <td>{!! $district->name !!}</td>
            <td>{!! $district->type !!}</td>
            <td>{!! $district->code_city !!}</td>
            <td>
                {!! Form::open(['route' => ['admin.districts.destroy', $district->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('admin.districts.show', [$district->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('admin.districts.edit', [$district->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>