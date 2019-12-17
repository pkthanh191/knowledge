<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $newsCategory->id !!}</p>
</div>

<!-- User Id Field -->
<div class="form-group">
    {!! Form::label('user_id', 'User Id:') !!}
    <p>{!! $newsCategory->user_id !!}</p>
</div>

<!-- Category News Id Field -->
<div class="form-group">
    {!! Form::label('category_news_id', 'Category News Id:') !!}
    <p>{!! $newsCategory->category_news_id !!}</p>
</div>

<!-- News Id Field -->
<div class="form-group">
    {!! Form::label('news_id', 'News Id:') !!}
    <p>{!! $newsCategory->news_id !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $newsCategory->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $newsCategory->updated_at !!}</p>
</div>

