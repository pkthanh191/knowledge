<div class="hotel-list listing-style3 hotel">
@foreach($documents as $key => $document)
    @include('frontend._partials.document_list_item')
@endforeach
</div>

@if($documents->hasPages())
    <div class="box-footer">
        {!! $documents->appends(['search' => Request::get('search'), 'mode'=>'list', 'danh-muc'=>Request::get('danh-muc')])->render() !!}
    </div>
@endif