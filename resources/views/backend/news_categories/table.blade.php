<table class="table table-responsive" id="newsCategories-table">
    <thead>
        <th>User Id</th>
        <th>Category News Id</th>
        <th>News Id</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($newsCategories as $newsCategory)
        <tr>
            <td>{!! $newsCategory->user_id !!}</td>
            <td>{!! $newsCategory->category_news_id !!}</td>
            <td>{!! $newsCategory->news_id !!}</td>
            <td>
                {!! Form::open(['route' => ['admin.newsCategories.destroy', $newsCategory->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('admin.newsCategories.show', [$newsCategory->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('admin.newsCategories.edit', [$newsCategory->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>