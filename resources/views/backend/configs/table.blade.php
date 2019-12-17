<table class="table table-bordered" id="configs-table">
    <thead>
    <th width="40px">@lang('messages.no')</th>
    {{--<th><input type="checkbox" name="checkedAll" id="checkedAll"  class="minimal checkAll" /></th>--}}
    <th class="col-md-2">@lang('messages.configs_name')</th>
    <th>@lang('messages.configs_value')</th>
    <th colspan="3">@lang('messages.actions')</th>
    </thead>
    <tbody>
    @if (count($configs) == 0)
        <tr class="text-center">
            <td colspan="5">@lang('messages.no-items')</td>
        </tr>
    @else

        @foreach($configs as $key=>$config)
            <tr>
                <td width="40px">{{($noConfigs++).'.'}}</td>
                {{--<td width="40px"><input type="checkbox" name="ids[]" value="{{ $key }}" class="minimal checkSingle" form="items"/></td>--}}
                <td>{{ $config['name']  }}</td>
                <td>{!! \App\Helpers\Helper::subDescription( $config['value'],'',300,false) !!}</td>
                <td width="100px">
                    {!! Form::open(['route' => ['admin.configs.destroy', $key], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        {{--<a href="{!! route('admin.configs.show', [$key]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>--}}
                        <a href="{!! route('admin.configs.edit', [$key]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {{--{!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('".Lang::get('messages.delete_confirm')."')"]) !!}--}}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>