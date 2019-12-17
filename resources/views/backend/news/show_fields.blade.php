<table class="table table-bordered">
    <tbody>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('name', __('messages.news_name')) !!}</th>
        <td><p>{!! $news->name !!}</p></td>
    </tr>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('category', __('messages.news_category')) !!}</th>
        <td>{!! Helper::formatCategories($news->categories) !!}</td>
    </tr>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('image', __('messages.news_image')) !!}</th>
        <td><p><img src="{!! $news->image !!}" height="200px"></p></td>
    </tr>

    <tr>
        <th style="width: 150px"
            scope="row">{!! Form::label('description', __('messages.category_news_description')) !!}</th>
        <td><p>{!! $news->description !!}</p></td>
    </tr>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('created_at', __('messages.created_at')) !!}</th>
        <td><p>{!! $news->created_at !!}</p></td>
    </tr>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('updated_at', __('messages.updated_at')) !!}</th>
        <td><p>{!! $news->updated_at !!}</p></td>
    </tr>

    </tbody>
</table>
