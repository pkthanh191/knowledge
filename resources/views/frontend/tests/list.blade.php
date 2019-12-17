<div class="hotel-list listing-style3 hotel">
@foreach($tests as $key => $test)
    @include('frontend._partials.test_list_item')
@endforeach
</div>

@if($tests->hasPages())
    <div class="box-footer">
        {!! $tests->appends(['search' => Request::get('search'), 'mode'=>'list', 'danh-muc'=>Request::get('danh-muc')])->render() !!}
    </div>
@endif