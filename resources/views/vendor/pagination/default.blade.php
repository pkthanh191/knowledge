@if ($paginator->hasPages())
    {!! __('pagination.info', ['from' => $paginator->firstItem(), 'to'=> $paginator->lastItem(), 'total' => $paginator->total()]) !!}
    <ul class="pagination pagination-sm no-margin pull-right">

        {{-- First && Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled"><span><<</span></li>
            <li class="disabled"><span><</span></li>
        @else
            <li><a href="{!!  array_first(array_first($elements))  !!}" rel="prev" data-toggle="tooltip" data-placement="top" title=@lang('messages.fist_page')> << </a></li>
            <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev" data-toggle="tooltip" data-placement="top" title=@lang('messages.previous_page')> < </a></li>
        @endif
        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled"><span>{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active"><span>{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next && LastPage Link --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" rel="next" data-toggle="tooltip" data-placement="top" title=@lang('messages.next_page')> > </a></li>
            <li><a href="{{ array_last(array_first($elements))  }}" rel="next" data-toggle="tooltip" data-placement="top" title=@lang('messages.last_page')> >> </a></li>
        @else
            <li class="disabled"><span> ></span></li>
            <li class="disabled"><span> >></span></li>
        @endif
    </ul>
@endif
