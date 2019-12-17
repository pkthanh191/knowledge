<table class="table table-bordered" id="categoryTests-table">
    <thead>
    <th>@lang('messages.no')</th>
    <th><input type="checkbox" name="checkedAll" id="checkedAll"  class="minimal checkAll" /></th>
    <th>@lang('messages.center_name')</th>
    <th>@lang('messages.center_phone')</th>
    <th>@lang('messages.center_email')</th>
    <th>@lang('messages.center_address')</th>
    <th>@lang('messages.center_image')</th>
    <th>@lang('messages.center_description')</th>
    <th colspan="3">@lang('messages.actions')</th>
    </thead>
    <tbody>
    @if (count($centers) == 0)
        <tr class="text-center">
            <td colspan="9">@lang('messages.no-items')</td>
        </tr>
    @else
        @foreach($centers as $key => $center)
            {{--@if($key != 0)--}}
            <tr>
                <td>{!! Helper::number_order($centers->currentPage(),$centers->perPage(),$key) !!}</td>
                <td width="40px"><input type="checkbox" name="ids[]" value="{{ $center->id }}" class="minimal checkSingle" form="items"/></td>
                <td width="250px"><a href="{!! route('admin.centers.show', [$center->id]) !!}">{!! $center->name !!}</a></td>
                <td width="100px">{!! $center->phone !!}</td>
                <td>{!! $center->email !!}</td>
                <td >{!! $center->address !!}</td>

                <td width="100px"><img src="{!! $center->image !!}" alt="{!! $center->image !!}" width="100px" height="100px"></td>


                <td width="200px">{!! \App\Helpers\Helper::subDescription($center->description, route('admin.centers.show', [$center->id])) !!} </td>
                <td class="col-md-1">
                    {!! Form::open(['route' => ['admin.centers.destroy', $center->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('admin.centers.show', [$center->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('admin.centers.edit', [$center->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('".Lang::get('messages.delete_confirm')."')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
            {{--@endif--}}
        @endforeach
    @endif
    </tbody>


</table>