
<div class="col-md-1"></div>
<div class="col-md-10" >
    {{--<img align="middle" style="margin-left:auto;margin-right: auto; display: block ;max-width: 360px; max-height: 500px ; border:1px solid dodgerblue" src="{!! $test->image !!}" alt="{!! $test->name !!}">--}}
    @if(is_null($test->image))
        <img style="margin-left:auto;margin-right: auto; display: block ;max-width: 360px; max-height: 500px ; border:1px solid dodgerblue" src="/public/uploads/default_image.png"  width="360px" height="360px">
    @else
        <img style="margin-left:auto;margin-right: auto; display: block ;max-width: 360px; max-height: 500px ; border:1px solid dodgerblue" src="{!! $test->image !!}" width="360px" height="360px">
    @endif
        <br>
</div>
<div class="col-md-1"></div>
<table class="table table-bordered">
    <tbody>
    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('name', __('messages.test_name')) !!}</th>
        <td><p>{!! $test->name !!}</p></td>
    </tr>
    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('parent_id', __('messages.test_duration')) !!}</th>
        <td><p>{!! $test->duration !!}</p></td>
    </tr>
    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('category', __('messages.test_category')) !!}</th>
        <td>
            @foreach(\App\Helpers\Helper::getCategoryTests($test) as $a)
                <p>{!! $a !!}</p>
            @endforeach
        </td>
    </tr>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('parent_id', __('messages.test_slug')) !!}</th>
        <td><p>{!! $test->slug !!}</p></td>
    </tr>
    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('parent_id', __('messages.test_comment_counts')) !!}</th>
        <td><p>{!! $test->comment_counts !!}</p></td>
    </tr>
    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('parent_id', __('messages.test_view_counts')) !!}</th>
        <td><p>{!! $test->view_counts !!}</p></td>
    </tr>

    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('file', __('messages.test_file')) !!}</th>
        <td><p>{!! $test->file !!}</p></td>
    </tr>
    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('file', __('messages.test_short_file')) !!}</th>
        <td><p>{!! $test->short_file !!}</p></td>
    </tr>
    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('link_down', __('messages.test_link_down')) !!}</th>
        <td><p>{!! $test->link_download !!}</p></td>
    </tr>
    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('parent_id', __('messages.test_user')) !!}</th>
        {{--<td><p>{!! $test->user_id !!}</p></td>--}}
        <td><p>{!! $test->user->name !!}</p></td>
    </tr>
    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('description', __('messages.test_description')) !!}</th>
        <td><p>{!! $test->description !!}</p></td>
    </tr>
    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('created_at', __('messages.created_at')) !!}</th>
        <td><p>{!! $test->created_at !!}</p></td>
    </tr>
    <tr>
        <th style="width: 150px" scope="row">{!! Form::label('updated_at', __('messages.updated_at')) !!}</th>
        <td><p>{!! $test->updated_at !!}</p></td>
    </tr>
    </tbody>
</table>









