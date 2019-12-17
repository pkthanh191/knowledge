<table class="table table-bordered">
    <tbody>
    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('name', __('messages.category_test_name')) !!}</th>
        <td><p>{!! $categoryTest->name !!}</p></td>
    </tr>
    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('description', __('messages.category_test_description')) !!}</th>
        <td><p>{!! $categoryTest->description !!}</p></td>
    </tr>
    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('parent_id', __('messages.category_test_parent_id')) !!}</th>
        <td><p>{!! \App\Http\Controllers\CategoryTestController::getNameParent($categoryTest) !!}</p></td>
    </tr>
    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('created_at', __('messages.created_at')) !!}</th>
        <td><p>{!! $categoryTest->created_at !!}</p></td>
    </tr>
    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('updated_at', __('messages.updated_at')) !!}</th>
        <td><p>{!! $categoryTest->updated_at !!}</p></td>
    </tr>
    </tbody>
</table>
