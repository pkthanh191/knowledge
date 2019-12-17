<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
            <h3 class="modal-title">@lang('messages.frontend_confirm_minus_money')</h3>
        </div>
        <div class="modal-body">
            @if(isset($trans_type) && $trans_type=='detail_tutorial')
          <p>@lang('messages.minus_money_confirm_tutorial')</p>
                <div id="loading_tutorial"></div>
                @elseif(isset($trans_type) && $trans_type=='download_1')
                <p>@lang('messages.minus_money_confirm_download')</p>
                <div id="loading_download_1"></div>
            @elseif(isset($trans_type) && $trans_type=='download_2')
                <p>@lang('messages.minus_money_confirm_download')</p>
                <div id="loading_download_2"></div>
            @elseif(isset($trans_type) && $trans_type=='comment')
                <p>@lang('messages.minus_money_confirm_comment')</p>
                <div id="loading_comment"></div>
            @endif
        </div>
        <div class="modal-footer">
            <button type="submit" class="button btn-small">@lang('messages.accept')</button>
            <button id="cancel" type="button" class="button btn-small btn-cancel"
                    data-dismiss="modal">@lang('messages.cancel')</button>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
