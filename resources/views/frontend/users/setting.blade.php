<div id="settings" class="tab-pane fade">
    <h2>@lang('messages.frontend_change_pass')</h2>
    <form method="POST" action="{{ route('users.change_pass') }}">
        {{ csrf_field() }}
        <div class="row form-group">
            <div class="col-xs-12 col-sm-6 col-md-12">
                <label>@lang('messages.frontend_old_pass')</label>
                <input name="old_password" type="password" pattern=".{6,}" required title="{{ trans('messages.frontend_password_title_validate') }}" class="form-control" placeholder="@lang('messages.frontend_old_password_placeholder')">
            </div>
        </div>
        <div class="row form-group">
            <div class="col-xs-12 col-sm-6 col-md-12">
                <label>@lang('messages.frontend_new_pass')</label>
                <input name="new_password" type="password" pattern=".{6,}" required title="{{ trans('messages.frontend_password_title_validate') }}" class="form-control" placeholder="@lang('messages.frontend_new_password_placeholder')">
            </div>
        </div>
        <div class="row form-group">
            <div class="col-xs-12 col-sm-6 col-md-12">
                <label>@lang('messages.frontend_confirm_pass')</label>
                <input name="new_password_confirmation" type="password" pattern=".{6,}" required title="{{ trans('messages.frontend_password_title_validate') }}" class="form-control" placeholder="@lang('messages.frontend_new_password_confirm_placeholder')">
            </div>
        </div>
        <div class="from-group">
            <button type="submit" class="button col-sms-2 col-sm-2">@lang('messages.frontend_update_pass')</button>
        </div>
    </form>
</div>