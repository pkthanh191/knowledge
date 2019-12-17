<!-- Grade Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('grade_id', 'Grade Id:') !!}
    {!! Form::text('grade_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Tutorial Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tutorial_id', 'Tutorial Id:') !!}
    {!! Form::text('tutorial_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('admin.gradeTutorials.index') !!}" class="btn btn-default">Cancel</a>
</div>
