<table class="table table-bordered">
    <tbody>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('name', __('messages.category_news_name')) !!}</th>
        <td><p>{!! $categoryNews->name !!}</p></td>
    </tr>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('parent_id', __('messages.category_news_parent')) !!}</th>
        <td><p>{!! \App\Models\CategoryNews::where('id',$categoryNews->parent_id)->pluck('name')->first() !!}</p></td>
    </tr>

    <tr>
        <th style="width: 150px"
            scope="row">{!! Form::label('description', __('messages.category_news_description')) !!}</th>
        <td><p>{!! $categoryNews->description !!}</p></td>
    </tr>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('created_at', __('messages.created_at')) !!}</th>
        <td><p>{!! $categoryNews->created_at !!}</p></td>
    </tr>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('updated_at', __('messages.updated_at')) !!}</th>
        <td><p>{!! $categoryNews->updated_at !!}</p></td>
    </tr>

    </tbody>
</table>