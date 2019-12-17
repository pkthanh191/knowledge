<!-- Title Field -->
<div class="form-group col-sm-12">
    {!! Form::label('title', Lang::get('messages.tutorials_title')) !!} <span class="required">(*)</span>
    {!! Form::text('title', null, ['class' => 'form-control','placeholder'=>Lang::get('messages.tutorials_placeholder_title')]) !!}
</div>

<!-- Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('phone', Lang::get('messages.tutorials_phone')) !!} <span class="required">(*)</span>
    {!! Form::text('phone', null, ['class' => 'form-control','placeholder'=>Lang::get('messages.tutorials_placeholder_phone')]) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6 col-lg-6">
    {!! Form::label('email', Lang::get('messages.tutorials_email')) !!}
    {!! Form::text('email', null, ['class' => 'form-control','placeholder'=>Lang::get('messages.tutorials_placeholder_email')]) !!}
</div>

<!-- City Id Field -->
<div class="form-group col-sm-3">
    {!! Form::label('city_id', Lang::get('messages.tutorials_city')) !!} <span class="required">(*)</span>
    {!! Form::select('city_id', $cities,isset($tutorial) ? $tutorial->district->city->code : null, ['class' => 'form-control']) !!}
</div>

<!-- District Id Field -->
<div class="form-group col-sm-3">
    {!! Form::label('district_id', Lang::get('messages.tutorials_district')) !!} <span class="required">(*)</span>
    {!! Form::select('district_id',$districts, isset($tutorial) ? $tutorial->district->id : null, ['class' => 'form-control', 'value' => old()!=[]? old('district_id') : '']) !!}
</div>
@if(old() != [])
    <script>
        window.onload = function() {
            getDistrictByCodeCity();
        };
    </script>
@endif
<!-- Address Field -->
<div class="form-group col-sm-6">
    {!! Form::label('address', Lang::get('messages.tutorials_address')) !!}
    {!! Form::text('address', null, ['class' => 'form-control', 'placeholder'=>Lang::get('messages.tutorials_placeholder_address')]) !!}
</div>

<!-- Frequency Field -->
<div class="form-group col-sm-3">
    {!! Form::label('frequency', Lang::get('messages.tutorials_frequency')) !!}
    {!! Form::number('frequency', null, ['class' => 'form-control','placeholder'=>Lang::get('messages.tutorials_placeholder_frequency'), 'oninput' => "validity.valid||(value='');"]) !!}
</div>

<!-- Salary Field -->
<div class="form-group col-sm-3">
    {!! Form::label('salary', Lang::get('messages.tutorials_salary')) !!}
    {!! Form::text('salary', null, ['class' => 'form-control','placeholder'=>Lang::get('messages.tutorials_placeholder_salary')]) !!}
</div>

<!-- Period Field -->
<div class="form-group col-sm-6">
    {!! Form::label('period', Lang::get('messages.tutorials_period')) !!}
    {!! Form::text('period', null, ['class' => 'form-control','placeholder'=>Lang::get('messages.tutorials_placeholder_period')]) !!}
</div>
<!-- Grade Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('grades', Lang::get('messages.tutorials_grade')) !!} <span class="required">(*)</span>
    @if(old()!=[] && old('grades')!=[])
        {!! Form::select('grade_ids', $grades,collect(old('grades')), ['class' => 'form-control', 'multiple' => 'multiple','id'=>'grade_ids','name'=> 'grades[]']) !!}
    @else
        {!! Form::select('grade_ids', $grades,isset($tutorial) ? $tutorial->grades : null, ['class' => 'form-control', 'multiple' => 'multiple','id'=>'grade_ids','name'=> 'grades[]']) !!}
    @endif
</div>

<!-- Subject Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('subjects', Lang::get('messages.tutorials_subject')) !!} <span class="required">(*)</span>
    @if(old()!=[] && old('subjects')!=[])
        {!! Form::select('', $subjects,collect(old('subjects')), ['class' => 'form-control','multiple' => 'multiple','id'=>'subject_ids','name'=> 'subjects[]']) !!}
    @else
        {!! Form::select('', $subjects,isset($tutorial) ? $tutorial->subjects : null, ['class' => 'form-control','multiple' => 'multiple','id'=>'subject_ids','name'=> 'subjects[]']) !!}
    @endif
</div>

<!-- Requirement Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('requirement', Lang::get('messages.tutorials_requirement')) !!}
    {!! Form::textarea('requirement', null, ['class' => 'form-control', 'placeholder'=>Lang::get('messages.tutorials_placeholder_requirement')]) !!}
</div>

<!-- Meta Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('meta_title', Lang::get('messages.meta_title')) !!}
    {!! Form::text('meta_title', null, ['class' => 'form-control']) !!}
</div>

<!-- Meta Keywords Field -->
<div class="form-group col-sm-6">
    {!! Form::label('meta_keywords', Lang::get('messages.meta_keywords')) !!}
    {!! Form::text('meta_keywords', null, ['class' => 'form-control']) !!}
</div>

<!-- Meta Description Field -->
<div class="form-group col-sm-12">
    {!! Form::label('meta_description', Lang::get('messages.meta_description')) !!}
    {!! Form::text('meta_description', null, ['class' => 'form-control']) !!}
</div>

<!-- Active Field -->
<div class="form-group col-sm-6">
    {!! Form::label('active', Lang::get('messages.tutorials_active')) !!}
    <label class="radio-inline">
        {!! Form::radio('active', 1, (isset($tutorial) && ($tutorial->active == 1)) ? true : false ,['class'=>'minimal']) !!} @lang('messages.tutorials_input_active')
    </label>

    <label class="radio-inline">
        {!! Form::radio('active', 0, (isset($tutorial) && ($tutorial->active == 0) || (!isset($tutorial))) ? true : false ,['class'=>'minimal']) !!} @lang('messages.tutorials_input_inactive')
    </label>

</div>

<!-- Confirm Field -->
<div class="form-group col-sm-6">
    {!! Form::label('confirm', Lang::get('messages.tutorials_confirm')) !!}
    <label class="radio-inline">
        {!! Form::radio('confirm', 1, (isset($tutorial) && ($tutorial->confirm == 1)) ? true : false ,['class'=>'minimal']) !!} @lang('messages.tutorials_input_confirm')
    </label>

    <label class="radio-inline">
        {!! Form::radio('confirm', 0, (isset($tutorial) && ($tutorial->confirm == 0) || (!isset($tutorial))) ? true : false ,['class'=>'minimal']) !!} @lang('messages.tutorials_input_unconfirm')
    </label>

</div>

<div class="form-group col-sm-12">
    {{ Form::button('<i class="fa fa-save"></i> '.Lang::get('messages.save'), array('class'=>'btn btn-primary', 'type'=>'submit')) }}
    <a href="{!! route('admin.tutorials.index') !!}" class="btn btn-default"><i
                class="fa fa-mail-reply"></i> @lang('messages.cancel')</a>
</div>
