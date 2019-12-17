<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::text('user_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Doc Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('doc_id', 'Doc Id:') !!}
    {!! Form::text('doc_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Doc Meta Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('doc_meta_id', 'Doc Meta Id:') !!}
    {!! Form::text('doc_meta_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Value Field -->
<div class="form-group col-sm-6">
    {!! Form::label('value', 'Value:') !!}
    {!! Form::text('value', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('admin.documentMetaValues.index') !!}" class="btn btn-default">Cancel</a>
</div>
