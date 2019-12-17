<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', __('messages.user_name')) !!}
    <span class="required">(*)</span>
    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => Lang::get('messages.user_name')]) !!}
</div>
<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', __('messages.user_email')) !!}
    <span class="required">(*)</span>
    @if(isset($edit))
        {!! Form::email('email', $user->email, ['class' => 'form-control', 'disabled']) !!}
    @else
        {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => Lang::get('messages.user_email')]) !!}
    @endif
</div>
<!-- Password Field -->
    @if(isset($edit))
        @if( $user->id == Auth::user()->id)
            <div class="form-group col-sm-6">
                {!! Form::label('password', __('messages.user_password')) !!}
                <span class="required">(*)</span>
                {!! Form::text('password', null, ['class' => 'form-control', 'placeholder' => Lang::get('messages.user_password_placeholder_edit')]) !!}
            </div>
        @endif
    @else
        <div class="form-group col-sm-6">
            {!! Form::label('password', __('messages.user_password')) !!}
            <span class="required">(*)</span>
            {!! Form::text('password', null, ['class' => 'form-control', 'placeholder' => Lang::get('messages.user_password_placeholder')]) !!}
        </div>
    @endif
<!-- Group Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', __('messages.user_group')) !!}
    <span class="required">(*)</span>
    @if(isset($edit))
        {!! Form::select('group_id', [0=>__('messages.select_user_group'),1=>Helper::convertGroupUser(1),2=>Helper::convertGroupUser(2),3=>Helper::convertGroupUser(3)],$user->group_id, ['class' => 'form-control', 'disabled']) !!}
    @else
        {!! Form::select('group_id', [0=>__('messages.select_user_group'),1=>Helper::convertGroupUser(1),2=>Helper::convertGroupUser(2),3=>Helper::convertGroupUser(3)],null, ['class' => 'form-control']) !!}
    @endif
</div>
@if(isset($edit) && $user->id != Auth::user()->id)
    <div class="clearfix"></div>
@endif
<!-- Avatar Field -->
<div class="form-group col-sm-6">
    {!! Form::label('avatar', __('messages.user_avatar')) !!}
    @if(isset($user))
        <div><img src="{!! $user->avatar !!}" style="height: 200px"></div>
        <br>
    @endif
    {!! Form::file('avatar') !!}
</div>
<div class="clearfix"></div>

<!-- Age Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', __('messages.user_age')) !!}
    {!! Form::number('age', null, ['class' => 'form-control', 'placeholder' => Lang::get('messages.user_age'), 'min'=>'0']) !!}
</div>
<!-- Sex Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', __('messages.user_sex')) !!}
    {!! Form::select('sex',[0=>__('messages.select_user_sex'),1=>Helper::convertSex(1),2=>Helper::convertSex(2),3=>Helper::convertSex(3)], null, ['class' => 'form-control']) !!}
</div>
<!-- Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', __('messages.user_phone')) !!}
    <span class="required">(*)</span>
    @if(isset($edit))
        {!! Form::text('phone', $user->phone, ['class' => 'form-control', 'disabled']) !!}
    @else
        {!! Form::text('phone', null, ['class' => 'form-control', 'placeholder' => Lang::get('messages.user_phone'), 'pattern'=>'^(01)[0-9]{9}$|^(09)[0-9]{8}$|^(\+841)[0-9]{9}$|^(\+849)[0-9]{8}$']) !!}
    @endif
</div>
<!-- Address Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', __('messages.user_address')) !!}
    {!! Form::text('address', null, ['class' => 'form-control', 'placeholder' => Lang::get('messages.user_address')]) !!}
</div>
<!-- Account_balance Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', __('messages.user_account_balance')) !!}
    <span class="required">(*)</span>
    @if(isset($edit))
        {!! Form::number('account_balance', $user->account_balance, ['class' => 'form-control', 'disabled']) !!}
    @else
        {!! Form::number('account_balance', null, ['class' => 'form-control', 'placeholder' => Lang::get('messages.user_account_balance')]) !!}
    @endif
</div>
<!-- Actived Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', __('messages.user_actived')) !!}
    {!! Form::select('actived',[''=>__('messages.selected'),1=>Helper::convertActived(1), 2=>Helper::convertActived(2),3=>Helper::convertActived(3)] ,null, ['class' => 'form-control']) !!}
</div>
<!-- Submit Field -->
<div class="form-group col-sm-12">
    {{ Form::button('<i class="fa fa-save"></i> '.Lang::get('messages.save'), array('class'=>'btn btn-primary', 'type'=>'submit')) }}
    <a href="{!! route('admin.users.index') !!}" class="btn btn-default"><i
                class="fa fa-mail-reply"></i> @lang('messages.cancel')</a>
</div>