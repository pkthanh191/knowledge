<div class="page-title-container">
    <div class="container">
        {{--<div class="page-title pull-left"></div>--}}
        @if ($breadcrumbs)
            <ul class="breadcrumbs pull-left">
            @foreach ($breadcrumbs as $index => $breadcrumb)
                    @if (!$breadcrumb->last)
                        @if ($index == 0)
                            <li><a href="{{ $breadcrumb->url }}"><i class="fa fa-home"></i> {{ $breadcrumb->title }}</a></li>
                        @else
                            <li><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
                        @endif
                    @else
                        <li class="active">{{ $breadcrumb->title }}</li>
                    @endif
                @endforeach
            </ul>
        @endif
    </div>
</div>