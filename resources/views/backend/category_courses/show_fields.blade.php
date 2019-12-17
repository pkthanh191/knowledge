<table class="table table-bordered">
    <tbody>
    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('name', __('messages.category_course_name')) !!}</th>
        <td><p>{!! $categoryCourse->name !!}</p></td>
    </tr>
    <tr>
        <th scope="row">{!! Form::label('description', __('messages.category_course_description')) !!}</th>
        <td><p>{!! $categoryCourse->description !!}</p></td>
    </tr>
    <tr>
        <th style="width: 150px"
            scope="row">{!! Form::label('category_course_type', __('messages.category_course_type')) !!}</th>

        <td><p>{!! Helper::convertCategoryType($categoryCourse->category_course_type) !!}</p></td>
    </tr>
    <tr>
        <th style="width: 150px"
            scope="row">{!! Form::label('parent_id', __('messages.category_course_parent_id')) !!}</th>

        <td><p>{!! $categoryCourse->parent['name'] !!}</p></td>
    </tr>
    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('created_at', __('messages.created_at')) !!}</th>
        <td><p>{!! $categoryCourse->created_at !!}</p></td>
    </tr>
    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('updated_at', __('messages.updated_at')) !!}</th>
        <td><p>{!! $categoryCourse->updated_at !!}</p></td>
    </tr>
    </tbody>
</table>

