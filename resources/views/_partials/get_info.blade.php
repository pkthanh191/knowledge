<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
            <h3 class="modal-title">@lang('messages.frontend_get_info')</h3>
        </div>
        <div class="modal-body">
            <div id="loading_info"></div>
            <div style="padding-bottom: 5px;">@lang('messages.require_recharge_card')</div>
            <div id="flash_messages_info" style="padding-bottom: 5px;"></div>
            <div class="row">
                <div class="col-sm-6">
                    <label>@lang('messages.tutorials_email')<span class="required"> (*)</span></label>
                    <input class="form-control" style="height:28px;width:250px"
                           placeholder="@lang('messages.tutorials_placeholder_email')" name="email" type="text"
                           id="email" value="">
                    <div id="flash_messages_info_email"></div>
                </div>

                <div class="col-sm-6">
                    <label for="address">@lang('messages.frontend_tutorial_phone')<span class="required"> (*)</span></label>
                    <input class="form-control" style="height:28px; width:250px"
                           placeholder="@lang('messages.tutorials_placeholder_phone')" name="phone"
                           type="text" id="phone" value="">
                    <div id="flash_messages_info_phone"></div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="button btn-small">@lang('messages.confirm')</button>
            <button type="button" id="cancel" class="button btn-small btn-cancel"
                    data-dismiss="modal">@lang('messages.cancel')</button>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>