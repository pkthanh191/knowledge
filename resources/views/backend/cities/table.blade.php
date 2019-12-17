<table class="table table-responsive" id="cities-table">
    <thead>
        <th>Code</th>
        <th>Name</th>
        <th>Type</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($cities as $city)
        <tr>
            <td>{!! $city->code !!}</td>
            <td>{!! $city->name !!}</td>
            <td>{!! $city->type !!}</td>
            <td>
                {!! Form::open(['route' => ['admin.cities.destroy', $city->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('admin.cities.show', [$city->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('admin.cities.edit', [$city->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>