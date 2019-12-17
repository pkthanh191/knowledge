
<!-- User Field -->
<div class="form-group col-sm-12 col-lg-6">
    {!! Form::label('user', __('messages.transactions_user')) !!} <span class="required">(*)</span>
    {!! Form::select('user_id', $users,null, ['class' => 'form-control']) !!}
</div>

<!-- Content Field -->
<div class="form-group col-sm-12 col-lg-6">
    {!! Form::label('content', __('messages.transactions_content')) !!} <span class="required">(*)</span>
    {!! Form::select('content', Helper::convertTransFields('content'),null, ['class' => 'form-control']) !!}
</div>

<!-- Money Transfer Field -->
<div class="form-group col-sm-6">
    {!! Form::label('money_transfer', Lang::get('messages.transactions_money')) !!} <span class="required">(*)</span>
    {!! Form::text('money_transfer', null, ['class' => 'form-control', 'id' => 'number-format', 'placeholder' => Lang::get('messages.transactions_money_placeholder')]) !!}
</div>

<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', __('messages.transactions_status')) !!} <span class="required">(*)</span>
    {!! Form::select('status',[''=>__('messages.selected'),1=>Helper::convertTransaction(1), 2=>Helper::convertTransaction(2),3=>Helper::convertTransaction(3)] ,null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::button('<i class="fa fa-save"></i> '.Lang::get('messages.save'), array('class'=>'btn btn-primary', 'type'=>'submit')) !!}
    <a href="{!! route('admin.transactions.index') !!}" class="btn btn-default"><i class="fa fa-mail-reply"></i> @lang('messages.cancel')</a>
</div>