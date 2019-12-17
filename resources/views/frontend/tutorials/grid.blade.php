<div class="cruise-list">
    <div class="sort-by-section box tutorial-header">
        <h2 class="tutorial-title"><i class="fa fa-th-large"></i> @lang('messages.frontend_tutorial_primary')</h2>
    </div>
    @if(count($tutorials_primary) == 0)
        <div class="row image-box hotel listing-style1 bg-item">
            <br>
            <p class="text-center">@lang('messages.no-items')</p>
        </div>
    @else
        @foreach ($tutorials_primary->chunk(3) as $chunk)
            <div class="row">
                @foreach ($chunk as $tutorial)
                    <div class="col-sm-4">
                        @include('frontend._partials.tutorial_grid_item')
                    </div>
                @endforeach
            </div>
        @endforeach
    @endif

    <div class="sort-by-section box tutorial-header">
        <h2 class="tutorial-title"><i class="fa fa-th-large"></i> @lang('messages.frontend_tutorial_secondary')</h2>
    </div>
    @if(count($tutorials_secondary) == 0)
        <div class="row image-box hotel listing-style1 bg-item">
            <br>
            <p class="text-center">@lang('messages.no-items')</p>
        </div>
    @else
        @foreach ($tutorials_secondary->chunk(3) as $chunk)
            <div class="row">
                @foreach ($chunk as $tutorial)
                    <div class="col-sm-4">
                        @include('frontend._partials.tutorial_grid_item')
                    </div>
                @endforeach
            </div>
        @endforeach
    @endif

    <div class="sort-by-section box tutorial-header">
        <h2 class="tutorial-title"><i class="fa fa-th-large"></i> @lang('messages.frontend_tutorial_high')</h2>
    </div>
    @if(count($tutorials_high) == 0)
        <div class="row image-box hotel listing-style1 bg-item">
            <br>
            <p class="text-center">@lang('messages.no-items')</p>
        </div>
    @else
        @foreach ($tutorials_high->chunk(3) as $chunk)
            <div class="row">
                @foreach ($chunk as $tutorial)
                    <div class="col-sm-4">
                        @include('frontend._partials.tutorial_grid_item')
                    </div>
                @endforeach
            </div>
        @endforeach
        <br>
    @endif

    <div class="sort-by-section box tutorial-header">
        <h2 class="tutorial-title"><i class="fa fa-th-large"></i> @lang('messages.frontend_tutorial_else')</h2>
    </div>
    @if(count($tutorials_else) == 0)
        <div class="row image-box hotel listing-style1 bg-item">
            <br>
            <p class="text-center">@lang('messages.no-items')</p>
        </div>
    @else
        @foreach ($tutorials_else->chunk(3) as $chunk)
            <div class="row">
                @foreach ($chunk as $tutorial)
                    <div class="col-sm-4">
                        @include('frontend._partials.tutorial_grid_item')
                    </div>
                @endforeach
            </div>
        @endforeach
        {{--@foreach($tutorials_else as $key => $tutorial)--}}
            {{--@if($key%3==0)--}}
                {{--<div class="row image-box hotel listing-style1 bg-item">--}}
                    {{--@include('frontend._partials.tutorial_grid_item')--}}
                    {{--@endif--}}

                    {{--@if($key%3!=0)--}}
                        {{--@include('frontend._partials.tutorial_grid_item')--}}
                    {{--@endif--}}

                    {{--@if($key==count($tutorials_else)-1||$key%3==2)--}}
                {{--</div>--}}
            {{--@endif--}}
        {{--@endforeach--}}
    @endif
</div>
