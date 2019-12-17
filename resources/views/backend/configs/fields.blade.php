@if(!is_null($config['name']))
    {!! Form::hidden('code', $key) !!}
@endif
<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', __('messages.configs_name')) !!}
    <span class="required">(*)</span>
    {!! Form::text('name', $config['name'], is_null($config['name']) ? ['class' => 'form-control'] : ['class' => 'form-control','readonly' => "true"]) !!}
</div>

<!-- Value Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('name', __('messages.configs_value')) !!}
    <span class="required">(*)</span>
    @if($key != 'information-account')
        {!! Form::text('value', $config['value'], ['class' => 'form-control']) !!}
    @else
        {!! Form::textarea('value', $config['value'], ['class' => 'form-control']) !!}
    @endif
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::button('<i class="fa fa-save"></i> '.Lang::get('messages.save'), ['class' => 'btn btn-primary','type'=>'submit']) !!}
    <a href="{!! route('admin.configs.index') !!}" class="btn btn-default"><i class="fa fa-mail-reply"></i> @lang('messages.cancel')</a>
</div>
