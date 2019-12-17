@if ($breadcrumbs)
    <ul class="breadcrumb">
        @foreach ($breadcrumbs as $index => $breadcrumb)
            @if (!$breadcrumb->last)
                @if ($index == 0)
                    <li><a href="{{ $breadcrumb->url }}"><i class="fa fa-dashboard"></i>{{ $breadcrumb->title }}</a></li>
                @else
                    <li><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
                @endif
            @else
                <li class="active">{{ $breadcrumb->title }}</li>
            @endif
        @endforeach
    </ul>
@endif