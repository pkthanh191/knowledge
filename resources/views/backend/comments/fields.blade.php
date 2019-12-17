<!-- Document Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('document_id', __('messages.comments_document')) !!}
    {!! Form::select('document_id', $documents,null, ['class'=>'form-control','id'=>'comments_doc']) !!}
</div>

<!-- Parent Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('parent_id', __('messages.comments_parent_id')) !!}
    {!! Form::select('parent_id',$comments, null, ['class' => 'form-control','id'=>'comments_parent']) !!}
</div>

<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', __('messages.comments_user_id')) !!}
    {!! Form::select('user_id',$users, null, ['class' => 'form-control']) !!}
</div>

<!-- Content Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('content', __('messages.comments_content')) !!}
    {!! Form::textarea('content', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::button('<i class="fa fa-save"></i> '.Lang::get('messages.save'), ['class' => 'btn btn-primary','type'=>'submit']) !!}
    <a href="{!! route('admin.comments.index') !!}" class="btn btn-default"><i class="fa fa-mail-reply"></i> @lang('messages.cancel')</a>
</div>
