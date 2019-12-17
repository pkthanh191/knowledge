<table class="table table-bordered" id="news-table">
    <thead>
    <th>@lang('messages.no')</th>
    <th><input type="checkbox" name="checkedAll" id="checkedAll" class="minimal checkAll"/></th>
    <th>@lang('messages.news_name')</th>
    <th>@lang('messages.news_category')</th>
    <th>@lang('messages.news_description')</th>
    <th>@lang('messages.news_image')</th>
    <th colspan="3">@lang('messages.actions')</th>
    </thead>
    <tbody>
    @if (count($news) == 0)
        <tr class="text-center">
            <td colspan="7">@lang('messages.no-items')</td>
        </tr>
    @else
        @foreach($news as $key => $new)
            <tr>
                <td>{!! Helper::number_order($news->currentPage(),$news->perPage(),$key) !!}</td>
                <td width="40px"><input type="checkbox" name="ids[]" value="{{ $new->id }}" class="minimal checkSingle"
                                        form="items"/></td>
                <td width="250px"><a href="{!! route('admin.news.show', [$new->id]) !!}">{!! $new->name !!}</a></td>
                <td width="200px">{!! Helper::formatCategories($new->categories) !!}</td>
                <td>{!!  Helper::subDescription($new->description, route('admin.news.show', [$new->id])) !!}</td>
                <td width="100px"><img src="{!! $new->image !!}" style="width: 100px; height: 100px;"></td>
                <td width="100px">
                    {!! Form::open(['route' => ['admin.news.destroy', $new->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('admin.news.show', [$new->id]) !!}" class='btn btn-default btn-xs'><i
                                    class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('admin.news.edit', [$new->id]) !!}" class='btn btn-default btn-xs'><i
                                    class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('".Lang::get('messages.delete_confirm')."')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>