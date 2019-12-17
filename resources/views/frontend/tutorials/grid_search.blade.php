<div class="cruise-list">
    @if(count($tutorials) == 0)
        <div class="row image-box hotel listing-style1 bg-item">
            <br>
            <p class="text-center">@lang('messages.no-items')</p>
        </div>
    @else
        @foreach ($tutorials->chunk(3) as $chunk)
            <div class="row">
                @foreach ($chunk as $tutorial)
                    <div class="col-sm-4">
                        @include('frontend._partials.tutorial_grid_item')
                    </div>
                @endforeach
            </div>
        @endforeach
    @endif
</div>