<table class="table table-bordered" id="pages-table">
    <thead>
    <th>@lang('messages.no')</th>
    {{--<th><input type="checkbox" name="checkedAll" id="checkedAll" class="minimal checkAll"/></th>--}}
    <th class="col-md-1">@lang('messages.static_pages_name')</th>
    <th>@lang('messages.static_pages_description')</th>
    <th colspan="3" class="col-md-1">@lang('messages.actions')</th>
    </thead>
    <tbody>
    @if (count($pages) == 0)
        <tr class="text-center">
            <td colspan="7">@lang('messages.no-items')</td>
        </tr>
    @else
        @foreach($pages as $key=>$page)
            <tr>
                <td>{!! ($key + 1).'.' !!}</td>
                {{--<td width="40px"><input type="checkbox" name="ids[]" value="{{ $page->id }}" class="minimal checkSingle"--}}
                                        {{--form="items"/></td>--}}
                <td>{!! $page->name !!}</td>
                <td>{!! \App\Helpers\Helper::subDescription($page->description,route('admin.pages.show', [$page->id])) !!}</td>
                <td>
                    {!! Form::open(['route' => ['admin.pages.destroy', $page->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('admin.pages.show', [$page->id]) !!}" class='btn btn-default btn-xs'><i
                                    class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('admin.pages.edit', [$page->id]) !!}" class='btn btn-default btn-xs'><i
                                    class="glyphicon glyphicon-edit"></i></a>
                        {{--{!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('".Lang::get('messages.delete_confirm')."')"]) !!}--}}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>