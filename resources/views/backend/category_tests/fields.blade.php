<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', Lang::get('messages.category_test_name')) !!}<span class="required"> (*)</span>
    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('messages.category_search_name_placeholder')]) !!}
</div>

<!-- Parent Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('parent_id', Lang::get('messages.category_test_parent_id')) !!}
    {!! Form::select('parent_id', $categories, null, ['class'=>'form-control']) !!}
</div>

{{-- OrderSort Field --}}
<div class="form-group col-sm-6">
    {!! Form::label('orderSort',  Lang::get('messages.category_test_orderSort')) !!}<span class="required"> (*)</span>
    {!! Form::number('orderSort', null, ['class' => 'form-control', 'placeholder' => __('messages.category_test_orderSort_placeholder'), 'oninput' => "validity.valid||(value='');"]) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', Lang::get('messages.category_test_description')) !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
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


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {{ Form::button('<i class="fa fa-save"></i> '.Lang::get('messages.save'), array('class'=>'btn btn-primary', 'type'=>'submit')) }}
    <a href="{!! route('admin.categoryTests.index') !!}" class="btn btn-default"><i class="fa fa-mail-reply"></i> @lang('messages.cancel')</a>
</div>

