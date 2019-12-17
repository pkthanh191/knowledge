<div class="hotel-list listing-style3 hotel">
@foreach($centers as $key => $center)
    @include('frontend._partials.center_list_item')
@endforeach
</div>

@if($centers->hasPages())
    <div class="box-footer">
        {!! $centers->appends(['search' => Request::get('search'), 'mode'=>'list', 'danh-muc'=>Request::get('danh-muc')])->render() !!}
    </div>
@endif