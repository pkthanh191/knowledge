<div class="hotel-list listing-style3 hotel">
@foreach($courses as $key => $course)
    @include('frontend._partials.course_list_item')
@endforeach
</div>

@if($courses->hasPages())
    <div class="box-footer">
        {!! $courses->appends(['search' => Request::get('search'), 'mode'=>'list', 'danh-muc'=>Request::get('danh-muc')])->render() !!}
    </div>
@endif