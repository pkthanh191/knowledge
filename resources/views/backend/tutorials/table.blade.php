<table class="table table-bordered" id="tutorials-table">
    <thead>
        <th>@lang('messages.no')</th>
        <th width="40px"><input type="checkbox" name="checkedAll" id="checkedAll"  class="minimal checkAll" /></th>
        <th>@lang('messages.tutorials_title')</th>
        <th>@lang('messages.tutorials_phone')</th>
        <th>@lang('messages.tutorials_subject')</th>
        <th>@lang('messages.tutorials_grade')</th>
        <th>@lang('messages.teacher_address')</th>
        <th class="col-md-1 text-center">@lang('messages.tutorials_active')
            {!! Form::open(['url' => ['/api/admin/tutorials/update/ActiveAll'], 'id'=> 'formActiveAll', 'method' => 'PATCH']) !!}
                @if($checkActive == false) <input type="hidden" name="activeType" value="1" id="hiddenActiveType" />
                @else <input type="hidden" name="activeType" value="0" id="hiddenActiveType" />@endif
            {!! Form::close() !!}
        </th>
        <th class="col-md-1 text-center">@lang('messages.tutorials_confirm')
            {!! Form::open(['url' => ['/api/admin/tutorials/update/ConfirmAll'], 'id'=> 'formConfirmAll', 'method' => 'PATCH']) !!}
                @if($checkConfirm == false)<input type="hidden" name="confirmType" value="1" id="hiddenConfirmType" />
                @else <input type="hidden" name="confirmType" value="0" id="hiddenConfirmType" />@endif
            {!! Form::close() !!}
        </th>
        <th colspan="3" class="col-md-1">@lang('messages.actions')</th>
    </thead>
    <tbody>
    @if(count($tutorials) == 0)
        <tr class="text-center">
            <td colspan="10"> @lang('messages.no-items')</td>
        </tr>
    @else
        @foreach($tutorials as $key=>$tutorial)
            <tr>
                <td>{!! Helper::number_order($tutorials->currentPage(),$tutorials->perPage(),$key) !!}</td>
                <td><input type="checkbox" name="ids[]" value="{{ $tutorial->id }}" class="minimal checkSingle" form="items"/></td>
                <td>{!! $tutorial->title !!}</td>
                <td>{!! $tutorial->phone !!}</td>
                <td>{!! \App\Helpers\Helper::formatCategories($tutorial->subjects) !!}</td>
                <td>{!! \App\Helpers\Helper::formatCategories($tutorial->grades) !!}</td>
                <td>
                    @if($tutorial->address)
                        {!! $tutorial->address.', '.$tutorial->district->name.', '.$tutorial->district->city->name !!}
                    @else
                        {!! $tutorial->district->name.', '.$tutorial->district->city->name !!}
                    @endif
                </td>
                <td class="text-center">
                    <input type="hidden" name="tutorialIds[]" value="{{ $tutorial->id }}" form="formConfirmAll"/>
                    {!! Form::open(['url' => ['/api/admin/tutorials/'.$tutorial->id.'/updateActive'], 'id'=> 'formUpdateActive', 'method' => 'PATCH']) !!}
                        @if($tutorial->active)
                            <button class="btn bg-olive btn-xs activeUpdate" data-id="{{ $tutorial->id }}" id="{{ "items-$tutorial->id" }}" data-toggle="tooltip" title="{{ __('messages.tutorials_button_deactive') }}"><i class="fa  fa-check"></i></button>
                        @else
                            <button class="btn btn-warning btn-xs activeUpdate" data-id="{{ $tutorial->id }}" id="{{ "items-$tutorial->id" }}" data-toggle="tooltip" title="{{ __('messages.tutorials_button_active') }}"><i class="fa fa-close"></i></button>
                        @endif
                    {!! Form::close() !!}
                </td>
                <td class="text-center">
                    <input type="hidden" name="tutorialIds[]" value="{{ $tutorial->id }}" form="formActiveAll"/>
                    {!! Form::open(['url' => ['/api/admin/tutorials/'.$tutorial->id.'/updateConfirm'], 'id'=> 'formUpdateConfirm', 'method' => 'PATCH']) !!}
                        @if($tutorial->confirm)
                            <button class="btn btn-green btn-xs confirmUpdate" data-id="{{ $tutorial->id }}" id="{{ "updateItems-$tutorial->id" }}" data-toggle="tooltip" title="{{ __('messages.tutorials_button_unconfirm') }}"><i class="fa  fa-check"></i></button>
                        @else
                            <button class="btn btn-yellow btn-xs confirmUpdate" data-id="{{ $tutorial->id }}" id="{{ "updateItems-$tutorial->id"}}" data-toggle="tooltip" title="{{ __('messages.tutorials_button_confirm') }}"><i class="fa fa-close"></i></button>
                        @endif
                    {!! Form::close() !!}
                </td>
                <td>
                    {!! Form::open(['route' => ['admin.tutorials.destroy', $tutorial->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('admin.tutorials.show', [$tutorial->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('admin.tutorials.edit', [$tutorial->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('".Lang::get('messages.delete_confirm')."')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>