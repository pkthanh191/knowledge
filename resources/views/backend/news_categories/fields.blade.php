<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::text('user_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Category News Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('category_news_id', 'Category News Id:') !!}
    {!! Form::text('category_news_id', null, ['class' => 'form-control']) !!}
</div>

<!-- News Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('news_id', 'News Id:') !!}
    {!! Form::text('news_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('admin.newsCategories.index') !!}" class="btn btn-default">Cancel</a>
</div>
