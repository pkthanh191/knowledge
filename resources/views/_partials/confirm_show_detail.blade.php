<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
            <h3 class="modal-title">@lang('messages.frontend_confirm_show_detail')</h3>
        </div>
        <div class="modal-body">
            <div class="flash_messages"></div>
            <div id="loading_show_detail"></div>
            <div class="row" style="margin-top: 10px;">
                <div class="col-md-3"><p>@lang('messages.input_code')</p></div>
                <div class="col-md-9"><input class="form-control" style="height:28px;" placeholder='@lang('messages.code_tutorial_placeholeder')' type="text" name="code" id="code"></div>
            </div>
        </div>
        <div class="modal-footer">
            <span class="pull-left">@lang('messages.confirm_code')&nbsp</span>
            <a href="" id="receive_code" class="pull-left" data-toggle="modal" style="color: deepskyblue"
               @if(Auth::check())
               data-target="#modal_minus_money"
               @else data-target="#modal_get_info"
                    @endif>@lang('messages.receive_code')</a>
            <button type="submit" class="button btn-small">@lang('messages.show_detail')</button>
            <button type="button" class="button btn-small btn-cancel"
                    data-dismiss="modal">@lang('messages.cancel')</button>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
