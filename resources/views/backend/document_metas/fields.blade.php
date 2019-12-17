 <!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', Lang::get('messages.document_metas_name')) !!}<span class="required"> (*)</span>
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Category Doc Meta Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('category_doc_meta_id', Lang::get('messages.document_metas_category_doc_meta')) !!}<span class="required"> (*)</span>
    {!! Form::select('category_doc_meta_id', $categories, null, ['class' => 'form-control']) !!}
</div>

 {{-- OrderSort Field --}}
 <div class="form-group col-sm-6">
     {!! Form::label('orderSort',  Lang::get('messages.document_metas_orderSort')) !!}<span class="required"> (*)</span>
     {!! Form::number('orderSort', null, ['class' => 'form-control', 'min' => 0, 'oninput' => "validity.valid||(value='');"]) !!}
 </div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', Lang::get('messages.document_metas_description')) !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {{ Form::button('<i class="fa fa-save"></i> '.Lang::get('messages.save'), array('class'=>'btn btn-primary', 'type'=>'submit')) }}
    <a href="{!! route('admin.documentMetas.index') !!}" class="btn btn-default"><i class="fa fa-mail-reply"></i> @lang('messages.cancel')</a>
</div>
