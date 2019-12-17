<table class="table table-bordered" id="categoryNews-table">
    <thead>
        <th>@lang('messages.no')</th>
        <th><input type="checkbox" name="checkedAll" id="checkedAll"  class="minimal checkAll" /></th>
        <th>@lang('messages.category_news_name')</th>
        <th>@lang('messages.category_news_short_description')</th>
        <th>@lang('messages.category_news_slug')</th>
        <th style="width: 58px">@lang('messages.category_news_orderSort')</th>
        <th colspan="3">@lang('messages.actions')</th>
    </thead>
    <tbody>
    @if (count($categoryNews) == 0)
        <tr class="text-center">
            <td colspan="6">@lang('messages.no-items')</td>
        </tr>
    @else
        @foreach($categoryNews as $key => $categoryNews)
            <tr>
                <td width="40px">{!! ++$key.('.') !!}</td>
                <td width="40px"><input type="checkbox" name="ids[]" value="{{ $categoryNews->id }}" class="minimal checkSingle"  form="items"/></td>
                <td width="250px"><a href="{!! route('admin.categoryNews.show', [$categoryNews->id]) !!}">{!! $categoryNews->name !!}</a></td>
                <td>{!! \App\Helpers\Helper::subDescription($categoryNews->description, route('admin.categoryNews.show', [$categoryNews->id])) !!}</td>
                <td>{!! $categoryNews->slug !!}</td>
                <td>{{ $categoryNews->orderSort }}</td>
                <td width="100px">
                    {!! Form::open(['route' => ['admin.categoryNews.destroy', $categoryNews->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('admin.categoryNews.show', [$categoryNews->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('admin.categoryNews.edit', [$categoryNews->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('".Lang::get('messages.delete_confirm')."')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>