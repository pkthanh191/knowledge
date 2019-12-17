<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', __('messages.news_name')) !!}
    <span class="required">(*)</span>
    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('messages.news_placeholder_name')]) !!}
</div>

<!-- Image Field -->
<div class="form-group col-sm-6">
    {!! Form::label('image', __('messages.news_image')) !!}
    @if(isset($news))
        <div><img src="{!! $news->image !!}" style="height: 200px; width: 300px"></div>
        <br>
    @endif
    {!! Form::file('image') !!}
</div>

<!-- Short Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('short_description', __('messages.document_short_description')) !!}
    {!! Form::textarea('short_description', null, ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', __('messages.news_description')) !!}
    {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => '50']) !!}
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
    <button class="btn btn-default" onclick="history.go(-1);"><i class="fa fa-mail-reply"></i>@lang('messages.cancel') </button>
</div>
