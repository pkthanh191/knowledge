<!-- Id Field -->
<div class="row">
    <div class="col-md-3">
        @if((!empty($teacher->image)) && file_exists(public_path($teacher->image)))
            <img src="{!! $teacher->image !!}" alt="{!! $teacher->name !!}" width="250px">
        @else
            <img src="/public/uploads/default-avatar.png" alt="{!! $teacher->name !!}" width="250px">
        @endif
    </div>
    <div class="col-md-9">
        <table class="table table-bordered">
            <tbody>
            <tr>
                <th style="width: 150px" scope="row">{!! Form::label('name', __('messages.teacher_name')) !!}</th>
                <td><p>{!! $teacher->name !!}</p></td>
            </tr>
            <tr>
                <th style="width: 150px" scope="row">{!! Form::label('description', __('messages.teacher_email')) !!}</th>
                <td><p>{!! $teacher->email !!}</p></td>
            </tr>
            <tr>
                <th style="width: 150px" scope="row">{!! Form::label('parent_id', __('messages.teacher_phone')) !!}</th>

                <td><p>{!! $teacher->phone !!}</p></td>
            </tr>
            <tr>
                <th style="width: 150px" scope="row">{!! Form::label('created_at', __('messages.teacher_address')) !!}</th>
                <td><p>{!! $teacher->address !!}</p></td>
            </tr>
            <tr>
                <th style="width: 150px" scope="row">{!! Form::label('updated_at', __('messages.teacher_description')) !!}</th>
                <td><p>{!! $teacher->description  !!}</p></td>
            </tr>
            <tr>
                <th style="width: 150px" scope="row">{!! Form::label('updated_at', __('messages.teacher_center')) !!}</th>
                <td>
                    @if($teacher->center_id !=0)
                        <p>{!! $teacher->center->name !!}</p>
                    @endif
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>


