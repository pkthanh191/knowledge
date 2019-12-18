<table class="table table-bordered" id="teachers-table">
    <thead>
        <th>@lang('messages.no')</th>
        <th><input type="checkbox" name="checkedAll" id="checkedAll"  class="minimal checkAll" /></th>
        <th class="col-md-1">@lang('messages.teacher_name')</th>
        <th class="col-md-1">@lang('messages.teacher_phone')</th>
        <th class="col-md-1">@lang('messages.teacher_email')</th>
        <th>@lang('messages.teacher_address')</th>
        <th style="width: 160px">@lang('messages.teacher_center')</th>
        <th style="width: 70px">@lang('messages.teacher_feature')</th>
        <th>@lang('messages.teacher_image')</th>
        <th colspan="3">@lang('messages.actions')</th>
    </thead>
    <tbody>
    @if (count($teachers) == 0)
        <tr class="text-center">
            <td colspan="9">@lang('messages.no-items')</td>
        </tr>
     @else
        @foreach($teachers as $key=>$teacher)
            <tr>
                <td>{!! Helper::number_order($teachers->currentPage(),$teachers->perPage(),$key) !!}</td>
                <td width="40px"><input type="checkbox" name="ids[]" value="{{ $teacher->id }}" class="minimal checkSingle" form="items"/></td>
                <td><a href="{!! route('admin.teachers.show', [$teacher->id]) !!}">{!! $teacher->name !!}</a></td>
                <td>{!! $teacher->phone !!}</td>
                <td>{!! $teacher->email !!}</td>
                <td>{!! $teacher->address !!}</td>
                <td>
                    @if($teacher->center_id != 0)
                        <a href="{!! route('admin.centers.show', [$teacher->center_id]) !!}"  target="_blank">{!! $teacher->center->name !!}</a>
                    @endif
                </td>
                <td>{!! Helper::convertFeature($teacher->feature) !!}</td>
                <td>
                    @if((!empty($teacher->image)) && file_exists(public_path($teacher->image)))
                        <img src="{!! $teacher->image !!}" alt="{!! $teacher->name !!}" width="100px" height="100px">
                    @else
                        <img src="/public/uploads/default_image.png" alt="{!! $teacher->name !!}" width="100px" height="100px">
                    @endif
                </td>
                <td class="col-xs-1">
                    {!! Form::open(['route' => ['admin.teachers.destroy', $teacher->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('admin.teachers.show', [$teacher->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('admin.teachers.edit', [$teacher->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('".Lang::get('messages.delete_confirm')."')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
      @endif
    </tbody>
</table>