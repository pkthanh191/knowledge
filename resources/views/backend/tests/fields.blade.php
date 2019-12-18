

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', Lang::get('messages.test_name')) !!} <span class="required">(*)</span>
    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => Lang::get('messages.test_name')]) !!}
</div>

<!-- Duration Field -->
<div class="form-group col-sm-6">
    {!! Form::label('duration',  Lang::get('messages.test_duration')) !!}
    {!! Form::number('duration', null, ['class' => 'form-control', 'placeholder' => __('messages.test_duration_placeholder'), 'min' => 0, 'oninput' => "validity.valid||(value='');"]) !!}
</div>

<!-- File Field -->
<div class="form-group col-sm-6">
    {!! Form::label('file', Lang::get('messages.test_file')) !!}
    {!! Form::file('file') !!}
</div>

<!-- Short File Field -->
<div class="form-group col-sm-6">
    {!! Form::label('short_file', Lang::get('messages.test_short_file')) !!}
    {!! Form::file('short_file') !!}
</div>

<!-- LinkDownload Field -->
<div class="form-group col-sm-6">
    {!! Form::label('link_download', Lang::get('messages.test_link_down')) !!}
    {!! Form::text('link_download', null, ['class' => 'form-control', 'placeholder' => Lang::get('messages.test_link_down')]) !!}
</div>

<!-- Image Field -->
<div class="form-group col-sm-6">
    {!! Form::label('image', Lang::get('messages.test_image')) !!}
    {!! Form::file('image') !!}
</div>

<!-- Show Image-->
<div class="form-group col-sm-6">
    @if(!isset($test)||is_null($test->image))
        <img src="/public/uploads/default-image.png"  width="200px" height="200px">
    @else
        <img src="{!! $test->image !!}" width="200px" height="200px">
    @endif
</div>

<!-- Short Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('short_description', __('messages.document_short_description')) !!}
    {!! Form::textarea('short_description', null, ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', Lang::get('messages.teacher_description')) !!}
    {!! Form::textarea('description', null, ['class' => 'form-control','placeholder' => Lang::get('messages.test_description')]) !!}
</div>

<!-- Meta Title Field -->
<div class="form-group col-sm-6 col-lg-6">
    {!! Form::label('meta_title', __('messages.meta_title')) !!}<span class="required"> (*)</span>
    {!! Form::text('meta_title', null, ['class' => 'form-control', 'placeholder' => __('messages.meta_title_placeholder')]) !!}
</div>

<!-- Meta Keywords Field -->
<div class="form-group col-sm-6 col-lg-6">
    {!! Form::label('meta_keywords', __('messages.meta_keywords')) !!}
    {!! Form::text('meta_keywords', null, ['class' => 'form-control', 'placeholder' => __('messages.meta_keywords_placeholder')]) !!}
</div>

<!-- Meta Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('meta_description', __('messages.meta_description')) !!}
    {!! Form::text('meta_description', null, ['class' => 'form-control', 'placeholder' => __('messages.meta_description_placeholder')]) !!}
</div>

<div class="clearfix"></div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {{ Form::button('<i class="fa fa-save"></i> '.Lang::get('messages.save'), array('class'=>'btn btn-primary', 'type'=>'submit')) }}
    <a href="{!! route('admin.tests.index') !!}" class="btn btn-default"><i class="fa fa-mail-reply"></i> @lang('messages.cancel')</a>
</div>
