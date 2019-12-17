<table class="table table-bordered" id="categoryDocs-table">
    <thead>
        <th>@lang('messages.no')</th>
        <th><input type="checkbox" name="checkedAll" id="checkedAll"  class="minimal checkAll" /></th>
        <th>@lang('messages.category_course_name')</th>
        <th>@lang('messages.category_course_description')</th>
        <th class="col-md-1">@lang('messages.category_course_type')</th>
        <th style="width: 58px">@lang('messages.category_course_orderSort')</th>
        <th colspan="3">@lang('messages.actions')</th>
    </thead>
    <tbody>
    @if (count($categoryCourses) == 0)
        <tr class="text-center">
            <td colspan="7">@lang('messages.no-items')</td>
        </tr>
    @else
        @foreach($categoryCourses as $key => $categoryCourse)
            <tr>
                <td width="40px">{!! $key +1 !!}</td>
                <td width="40px"><input type="checkbox" name="ids[]" value="{{ $categoryCourse->id }}" class="minimal checkSingle" form="items" /></td>
                <td width="250px"><a href="{!! route('admin.categoryCourses.show', [$categoryCourse->id]) !!}">{!! $categoryCourse->name !!}</a></td>
                <td>{!! \App\Helpers\Helper::subDescription($categoryCourse->description, route('admin.categoryCourses.show', [$categoryCourse->id])) !!} </td>
                <td>
                    {!! Helper::convertCategoryType($categoryCourse->category_course_type) !!}
                </td>
                <td>{{ $categoryCourse->orderSort }}</td>
                <td width="100px">
                    {!! Form::open(['route' => ['admin.categoryCourses.destroy', $categoryCourse->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('admin.categoryCourses.show', [$categoryCourse->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('admin.categoryCourses.edit', [$categoryCourse->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('".Lang::get('messages.delete_confirm')."')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>