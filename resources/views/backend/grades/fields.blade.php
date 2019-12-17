<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', Lang::get('messages.grades_name')) !!} <span class="required">(*)</span>
    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => Lang::get('messages.grades_placeholder_name')]) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::button('<i class="fa fa-save"></i> '.Lang::get('messages.save'), array('class'=>'btn btn-primary', 'type'=>'submit')) !!}
    <a href="{!! route('admin.grades.index') !!}" class="btn btn-default"><i
                class="fa fa-mail-reply"></i> @lang('messages.cancel')</a>
</div>
