<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', Lang::get('messages.course_name')) !!} <span class="required">(*)</span>
    {!! Form::text('name', null, ['class' => 'form-control','placeholder' => Lang::get('messages.course_name_placeholder')]) !!}
</div>

<!-- Center Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('center_id', Lang::get('messages.course_label_center_teacher')) !!} <span class="required">(*)</span>
    {!!Form::select('center_id', $centers, null, ['class' => 'form-control','id'=> 'center'])!!}
</div>

<!-- Teacher Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('', Lang::get('messages.course_teacher_blank')) !!}
    {!!Form::select('teacher_id', $teachers, null, ['class' => 'form-control','id'=> 'teacher'])!!}
</div>

<!-- Start Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('start_date', Lang::get('messages.course_start_date')) !!}
    {!! Form::date('start_date', $start_date, ['class' => 'form-control', 'min'=>'2000-1-1', 'max'=>'2020-12-31']) !!}
</div>

<!-- End Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('end_date', Lang::get('messages.course_end_date')) !!}
    {!! Form::date('end_date', $end_date, ['class' => 'form-control', 'min'=>'2000-1-1', 'max'=>'2020-12-31']) !!}
</div>

<!-- Duration Field -->
<div class="form-group col-sm-6">
    {!! Form::label('duration', Lang::get('messages.course_duration')) !!}
    {!! Form::number('duration', null, ['class' => 'form-control','placeholder' => Lang::get('messages.course_duration_placeholder')]) !!}
</div>

<!-- Cost Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cost', Lang::get('messages.course_cost')) !!}
    {!! Form::text('cost', null, ['class' => 'form-control loan-input', 'id' => 'number-format', 'placeholder'=> Lang::get('messages.course_cost_placeholder')]) !!}
</div>

<!-- Image Field -->
<div class="form-group col-sm-6">
    {!! Form::label('image', Lang::get('messages.course_image')) !!}
    {!! Form::file('image') !!}
</div>

<!-- Image view -->
<div class="form-group col-sm-6">
    @if(isset($course))
        <img src="{{ $course->image }}" width="200px" height="200px">
    @endif
</div>
<!-- Short Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('short_description', __('messages.document_short_description')) !!}
    {!! Form::textarea('short_description', null, ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', Lang::get('messages.course_description')) !!}
    {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => Lang::get('messages.course_description_placeholder')]) !!}
</div>

<!-- Meta Title Field -->
<div class="form-group col-sm-6 col-lg-6">
    {!! Form::label('meta_title', __('messages.meta_title')) !!}<span class="required"> (*)</span>
    {!! Form::text('meta_title', null, ['class' => 'form-control', 'placeholder' => Lang::get('messages.meta_title_placeholder'),]) !!}
</div>

<!-- Meta Keywords Field -->
<div class="form-group col-sm-6 col-lg-6">
    {!! Form::label('meta_keywords', __('messages.meta_keywords')) !!}
    {!! Form::text('meta_keywords', null, ['class' => 'form-control', 'placeholder' => Lang::get('messages.meta_keywords_placeholder'),]) !!}
</div>

<!-- Meta Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('meta_description', __('messages.meta_description')) !!}
    {!! Form::text('meta_description', null, ['class' => 'form-control', 'placeholder' => Lang::get('messages.meta_description_placeholder'),]) !!}
</div>

<div class="clearfix"></div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::button('<i class="fa fa-save"></i> '.Lang::get('messages.save'), array('class'=>'btn btn-primary', 'type'=>'submit')) !!}
    <a href="{!! route('admin.courses.index') !!}" class="btn btn-default"><i class="fa fa-mail-reply"></i> @lang('messages.cancel')</a>
</div>
