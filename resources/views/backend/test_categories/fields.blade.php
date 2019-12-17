<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::text('user_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Category Test Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('category_test_id', 'Category Test Id:') !!}
    {!! Form::text('category_test_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Test Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('test_id', 'Test Id:') !!}
    {!! Form::text('test_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('admin.testCategories.index') !!}" class="btn btn-default">Cancel</a>
</div>
