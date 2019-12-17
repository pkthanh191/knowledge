<div class="hotel-list listing-style3 hotel">
@foreach($teachers as $key => $teacher)
    @include('frontend._partials.teacher_list_item')
@endforeach
</div>

@if($teachers->hasPages())
    <div class="box-footer">
        {!! $teachers->appends(['search' => Request::get('search'), 'mode'=>'list', 'danh-muc'=>Request::get('danh-muc')])->render() !!}
    </div>
@endif