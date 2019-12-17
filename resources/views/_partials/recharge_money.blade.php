<div class="modal fade" id="modal-recharge-money" style="display: none;">
    <form>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">@lang('messages.frontend-info-owner')</h4>
                </div>
                <div class="modal-body">
                    {!! config('system.information-account.value') !!}
                </div>
                <div class="modal-footer">
                    <button type="button" id="cancel" class="button btn-small btn-cancel" data-dismiss="modal">@lang('messages.cancel')</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </form>
</div>