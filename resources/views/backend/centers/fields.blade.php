<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name',Lang::get('messages.center_name')) !!}<span class="required"> (*)</span>
    {!! Form::text('name', null, ['class' => 'form-control','placeholder' => Lang::get('messages.center_input_name_placeholder')]) !!}
</div>

<!-- Address Field -->
<div class="form-group col-sm-6">
    {!! Form::label('address', Lang::get('messages.center_address')) !!}
    {!! Form::text('address', null, ['class' => 'form-control','placeholder' => Lang::get('messages.center_input_address_placeholder')]) !!}
</div>

<!-- Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('phone', Lang::get('messages.center_phone')) !!}<span class="required"> (*)</span>
    {!! Form::text('phone', null, ['class' => 'form-control','placeholder'=>Lang::get('messages.center_input_phone_placeholder')]) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', Lang::get('messages.center_email')) !!}<span class="required"> (*)</span>
    {!! Form::text('email', null, ['class' => 'form-control','placeholder' => Lang::get('messages.center_input_email_placeholder')]) !!}
</div>


<!-- Image Field -->
<div class="form-group col-sm-6">
    {!! Form::label('image', Lang::get('messages.center_image')) !!}
    {!! Form::file('image') !!}
</div>

<!-- Short Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('short_description', __('messages.document_short_description')) !!}
    {!! Form::textarea('short_description', null, ['class' => 'form-control','placeholder' => Lang::get('messages.center_input_short_description_placeholder')]) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', Lang::get('messages.center_description')) !!}
    {!! Form::textarea('description', null, ['class' => 'form-control','placeholder' => Lang::get('messages.center_input_description_placeholder')]) !!}
</div>

<!-- Meta Title Field -->
<div class="form-group col-sm-6 col-lg-6">
    {!! Form::label('meta_title', __('messages.meta_title')) !!}<span class="required"> (*)</span>
    {!! Form::text('meta_title', null, ['class' => 'form-control','placeholder' => Lang::get('messages.meta_title_placeholder')]) !!}
</div>

<!-- Meta Keywords Field -->
<div class="form-group col-sm-6 col-lg-6">
    {!! Form::label('meta_keywords', __('messages.meta_keywords')) !!}
    {!! Form::text('meta_keywords', null, ['class' => 'form-control','placeholder' => Lang::get('messages.meta_keywords_placeholder')]) !!}
</div>

<!-- Meta Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('meta_description', __('messages.meta_description')) !!}
    {!! Form::text('meta_description', null, ['class' => 'form-control','placeholder' => Lang::get('messages.meta_description_placeholder')]) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {{ Form::button('<i class="fa fa-save"></i> '.Lang::get('messages.save'), array('class'=>'btn btn-primary', 'type'=>'submit')) }}
    <a href="{!! route('admin.centers.index') !!}" class="btn btn-default"><i class="fa fa-mail-reply"></i> @lang('messages.cancel')</a>

</div>
