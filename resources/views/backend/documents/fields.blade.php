<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', __('messages.document_name')) !!}<span class="required"> (*)</span>
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>
<div class="clearfix"></div>

{{--Link field--}}
<div class="form-group col-sm-6">
    {!! Form::label('link_download', __('messages.document_link_download')) !!}
    {!! Form::text('link_download', null, ['class' => 'form-control']) !!}
</div>

{{--File field--}}
<div class="form-group col-sm-6">
    {!! Form::label('file', __('messages.document_file')) !!}
    {!! Form::file('file', null, ['class' => 'form-control']) !!}
</div>
<div class="clearfix"></div>
{{--Short File field--}}
<div class="form-group col-sm-6">
    {!! Form::label('short_file', __('messages.document_short_file')) !!}
    {!! Form::file('short_file', null, ['class' => 'form-control']) !!}
</div>

<!-- Image Field -->
<div class="form-group col-sm-6">
    {!! Form::label('image', __('messages.document_image')) !!}
    @if(isset($document))
        <div>
            <img src="{{asset($document->image)}}" style="height: 200px">
        </div>
        <br>
    @endif
    {!! Form::file('image') !!}
</div>

<div class="form-group col-sm-12">
    {{--{{dd(old('document_meta'))}}--}}
    {!! Form::label('category_doc_meta_id', __('messages.document_category_doc_metas')) !!}{{--<span
            class="required"> (*)</span>--}}
    {!! Form::select('category_doc_meta_id', $categoryDocMetas, isset($selectedCategoryDocMeta) ? $selectedCategoryDocMeta : null, ['class' => 'form-control']) !!}
</div>
<div id="document_metas">
    @if(old() != [])
        @php
        if(old('category_doc_meta_id') != 0){
            foreach ($categoryMetas as $category){
                if ($category->id == old('category_doc_meta_id'))
                    $categoryMeta = $category;
            }
            $metas = $categoryMeta->metas;
        }
        else $metas = [];
        @endphp
        @foreach($metas as $meta)
            <div class="form-group col-sm-6">
                {!! Form::label( $meta->name ) !!}
                {!! Form::text('document_meta['."$meta->id".']', old('document_meta')[$meta->id], ['class' => 'form-control']) !!}
            </div>
        @endforeach
    @elseif(isset($documentMetaValues))
        @foreach($documentMetaValues as $documentMetaValue)
            <tr>
                <div class="form-group col-sm-6">
                    {!! Form::label( $documentMetaValue->documentMeta->name ) !!}
                    {!! Form::text('document_meta['."$documentMetaValue->doc_meta_id".']', $documentMetaValue->value, ['class' => 'form-control']) !!}
                </div>
            </tr>
        @endforeach
    @endif
</div>

<!-- Short Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('short_description', __('messages.document_short_description')) !!}
    {!! Form::textarea('short_description', null, ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', __('messages.document_description')) !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Meta Title Field -->
<div class="form-group col-sm-6 col-lg-6">
    {!! Form::label('meta_title', __('messages.meta_title')) !!}<span class="required"> (*)</span>
    {!! Form::text('meta_title', null, ['class' => 'form-control']) !!}
</div>

<!-- Meta Keywords Field -->
<div class="form-group col-sm-6 col-lg-6">
    {!! Form::label('meta_keywords', __('messages.meta_keywords')) !!}
    {!! Form::text('meta_keywords', null, ['class' => 'form-control']) !!}
</div>

<!-- Meta Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('meta_description', __('messages.meta_description')) !!}
    {!! Form::text('meta_description', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {{ Form::button('<i class="fa fa-save"></i> '.Lang::get('messages.save'), array('class'=>'btn btn-primary', 'type'=>'submit')) }}
    <a href="{!! route('admin.documents.index') !!}" class="btn btn-default"><i
                class="fa fa-mail-reply"></i> @lang('messages.cancel')</a>
</div>

