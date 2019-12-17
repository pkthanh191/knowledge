<table class="table table-bordered">
    <tbody>
    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('name', __('messages.course_name')) !!}</th>
        <td><p>{!! $course->name !!}</p></td>
    </tr>
    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('description', __('messages.course_start_date')) !!}</th>
        <td><p>{!! $course->start_date !!}</p></td>
    </tr>
    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('parent_id', __('messages.course_end_date')) !!}</th>

        <td><p>{!! $course->end_date !!}</p></td>
    </tr>
    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('created_at', __('messages.course_duration')) !!}</th>
        <td><p>{!! $course->duration !!}</p></td>
    </tr>
    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('updated_at', __('messages.course_cost')) !!}</th>
        <td><p>{!! $course->cost !!}</p></td>
    </tr>
    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('updated_at', __('messages.course_slug')) !!}</th>
        <td><p>{!! $course->slug !!}</p></td>
    </tr>
    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('updated_at', __('messages.course_center')) !!}</th>
        <td>
            <p>
                @if($course->center_id !=0)
                    {!! $course->center->name !!}
                @endif
            </p>
        </td>
    </tr>
    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('updated_at', __('messages.course_teacher')) !!}</th>
        <td>
            <p>
                @if($course->teacher_id !=0)
                    {!! $course->teacher->name !!}
                @endif
            </p>
        </td>
    </tr>
    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('created_at', __('messages.created_at')) !!}</th>
        <td><p>{!! $course->created_at !!}</p></td>
    </tr>
    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('updated_at', __('messages.updated_at')) !!}</th>
        <td><p>{!! $course->updated_at !!}</p></td>
    </tr>
    </tbody>
</table>
