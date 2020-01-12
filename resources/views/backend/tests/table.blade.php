<table class="table table-bordered" id="tests-table">
    <thead>
        <th width="20px">@lang('messages.no')</th>
        <th><input type="checkbox" name="checkedAll" id="checkedAll"  class="minimal checkAll" /></th>
        <th class="col-md-2">@lang('messages.test_name')</th>
        <th width="75px">@lang('messages.test_duration')</th>
        <th width="160px">@lang('messages.test_category')</th>
        <th>@lang('messages.test_description')</th>
        {{--<th>@lang('messages.test_slug')</th>--}}
        <th width="80px">@lang('messages.test_comment_counts')</th>
        <th width="75px">@lang('messages.test_view_counts')</th>

        <th>@lang('messages.test_image')</th>
        {{--<th>@lang('messages.test_user')</th>--}}
        <th class="col-md-1">@lang('messages.actions')</th>
    </thead>
    <tbody>
        @if (count($tests) == 0)
            <tr class="text-center">
                <td colspan="9">@lang('messages.no-items')</td>
            </tr>
        @else
            @foreach($tests as $index=>$test)
                <tr>
                    <td>{!! Helper::number_order($tests->currentPage(),$tests->perPage(),$index) !!}</td>
                    <td width="35px"><input type="checkbox" name="ids[]" value="{{ $test->id }}" class="minimal checkSingle" form="items"/></td>
                    <td width="180px"><a href="{!! route('admin.tests.show', [$test->id]) !!}">{!! $test->name !!}</a></td>
                    <td>{!! $test->duration !!}</td>
                    <td>{!! Helper::formatCategories($test->categories,"<br>") !!}</td>
                    <td>{!!\App\Helpers\Helper::subDescription( $test->description,route('admin.tests.show', [$test->id]))!!}</td>
                    {{--<td>{!! $test->slug !!}</td>--}}
                    <td>{!! $test->comment_counts !!}</td>
                    <td>{!! $test->view_counts !!}</td>
                    <td><img src="{{asset('/public/'.$test->image)}}" width="150px"></td>
                    <td>
                        {!! Form::open(['route' => ['admin.tests.destroy', $test->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{!! route('admin.tests.show', [$test->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                            <a href="{!! route('admin.tests.edit', [$test->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                            {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('".Lang::get('messages.delete_confirm')."')"]) !!}
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        @endif

    </tbody>
</table>