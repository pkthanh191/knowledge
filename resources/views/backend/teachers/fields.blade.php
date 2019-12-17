<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', Lang::get('messages.teacher_name')) !!} <span class="required">(*)</span>
    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => Lang::get('messages.teacher_name_placeholder')]) !!}
</div>

<!-- Center Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('center_id', Lang::get('messages.teacher_center')) !!}
    {!! Form::select('center_id', $centers, null, ['class'=>'form-control']) !!}
</div>

<!-- Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('phone', Lang::get('messages.teacher_phone')) !!} <span class="required">(*)</span>
    {!! Form::text('phone', null, ['class' => 'form-control','placeholder' => Lang::get('messages.teacher_phone_placeholder')]) !!}
</div>


<!-- Address Field -->
<div class="form-group col-sm-6">
    {!! Form::label('address', Lang::get('messages.teacher_address')) !!}
    {!! Form::text('address', null, ['class' => 'form-control','placeholder' => Lang::get('messages.teacher_address_placeholder')]) !!}
</div>


<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', Lang::get('messages.teacher_email')) !!} <span class="required">(*)</span>
    {!! Form::text('email', null, ['class' => 'form-control','placeholder' => Lang::get('messages.teacher_email_placeholder')]) !!}
</div>

{{--Feature Field--}}

<div class="form-group col-sm-6">
    {!! Form::label('feature', Lang::get('messages.teacher_feature'),['style' => 'display: block']) !!}
    <label class="radio-inline">
        {!! Form::radio('feature', 1, (isset($teacher) && ($teacher->feature == 1)) ? true : false ,['class'=>'minimal']) !!} @lang('messages.teacher_feature_on')
    </label>

    <label class="radio-inline">
        {!! Form::radio('feature', 0, (isset($teacher) && ($teacher->feature == 0) || (!isset($teacher))) ? true : false ,['class'=>'minimal']) !!} @lang('messages.teacher_feature_off')
    </label>

</div>

{{--<div class="form-group col-sm-6">--}}
    {{--{!! Form::label('feature', Lang::get('messages.teacher_feature')) !!}--}}
    {{--{!! Form::select('feature',[''=>__('messages.selected'),1=>Helper::convertFeature(1), 2=>Helper::convertFeature(2)] ,null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}

<div class="row"></div>
<!-- Image Field -->
<div class="form-group col-sm-6">
    {!! Form::label('image', Lang::get('messages.course_image')) !!}
    {!! Form::file('image') !!}
</div>

<!-- Image view -->
<div class="form-group col-sm-6">
    @if(isset($teacher))
        <img src="{{ $teacher->image }}" width="200px" height="200px">
    @endif
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', Lang::get('messages.teacher_description')) !!}
    {!! Form::textarea('description', null, ['class' => 'form-control','placeholder' => Lang::get('messages.teacher_description')]) !!}
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
    {!! Form::button('<i class="fa fa-save"></i> '.Lang::get('messages.save'), array('class'=>'btn btn-primary', 'type'=>'submit')) !!}
    <a href="{!! route('admin.teachers.index') !!}" class="btn btn-default"><i
                class="fa fa-mail-reply"></i> @lang('messages.cancel')</a>
</div>
