<table class="table table-bordered" id="courses-table">
    <thead>
        <th>@lang('messages.no')</th>
        <th><input type="checkbox" name="checkedAll" id="checkedAll"  class="minimal checkAll" /></th>
        <th>@lang('messages.course_name')</th>
        <th>@lang('messages.course_category')</th>
        <th>@lang('messages.course_center')</th>
        <th>@lang('messages.course_teacher')</th>
        <th>@lang('messages.course_image')</th>
        <th colspan="3" class="col-md-1">@lang('messages.actions')</th>
    </thead>
    <tbody>
    {{--{{ dd($courses->perPage()) }}--}}
    @if(count($courses)==0)
        <tr class="text-center">
            <td colspan="7">@lang('messages.no-items')</td>
        </tr>
    @else
        @foreach($courses as $key => $course)
            <tr>
                <td>{!! Helper::number_order($courses->currentPage(),$courses->perPage(),$key) !!}</td>
                <td width="40px"><input type="checkbox" name="ids[]" value="{{ $course->id }}" class="minimal checkSingle" form="items"/></td>
                <td><a href="{!! route('admin.courses.show', [$course->id]) !!}">{!! $course->name !!}</a></td>
                <td>
                    {!! Helper::formatCategories($course->categories) !!}
                </td>
                <td>
                    @if($course->center_id !=0)
                        {!! $course->center->name !!}
                    @endif
                </td>
                <td>
                    @if($course->teacher_id !=0)
                        {!! $course->teacher->name !!}
                    @endif
                </td>
                <td>
                    <img src="{!! $course->image !!}" alt="{!! $course->image !!}" width="100px" height="100px">
                </td>
                <td>
                    {!! Form::open(['route' => ['admin.courses.destroy', $course->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('admin.courses.show', [$course->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('admin.courses.edit', [$course->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('".Lang::get('messages.delete_confirm')."')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>