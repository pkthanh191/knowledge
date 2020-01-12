<table class="table table-bordered" id="banners-table">
    <thead>
        <th width="40px">@lang('messages.no')</th>
        <th><input type="checkbox" name="checkedAll" id="checkedAll"  class="minimal checkAll" /></th>
        <th>@lang('messages.banner_name')</th>
        <th>@lang('messages.banner_image')</th>
        <th>@lang('messages.banner_url')</th>
{{--        <th>@lang('messages.banner_description')</th>--}}
        {{--<th>@lang('messages.banner_position')</th>--}}
        <th>@lang('messages.banner_status')</th>
        <th width="100px">@lang('messages.actions')</th>
    </thead>
    <tbody>
    @foreach($banners as $key => $banner)
        <tr>
            <td>{!! Helper::number_order($banners->currentPage(),$banners->perPage(),$key) !!}</td>
            <td width="40px"><input type="checkbox" name="ids[]" value="{{ $banner->id }}" class="minimal checkSingle" form="items"/></td>
            <td>{!! $banner->name !!}</td>
            <td>
                @if((!empty($banner->image)) && file_exists(public_path($banner->image)))
                    <img src="{!! $banner->image !!}" alt="{!! $banner->name !!}" width="100px" height="100px">
                @else
                    <img src="/public/uploads/default-avatar.png" alt="{!! $banner->name !!}" width="100px" height="100px">
                @endif
            </td>
            <td><a href="{!! $banner->url !!}" target="_blank">{!! $banner->url !!}</a></td>
{{--            <td>{!!\App\Helpers\Helper::subDescription( $banner->description,route('admin.banners.show', [$banner->id]))!!}</td>--}}
            {{--<td>{!! Helper::convertPosition($banner->position) !!}</td>--}}
            <td>{!! Helper::convertChecked($banner->status) !!}</td>
            <td  width="100px">
                {!! Form::open(['route' => ['admin.banners.destroy', $banner->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('admin.banners.show', [$banner->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('admin.banners.edit', [$banner->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('".Lang::get('messages.delete_confirm')."')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>