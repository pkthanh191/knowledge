<div class="jquery-accordion-menu white">
    <div class="jquery-accordion-menu-header uppercase">
        <a href="{{ route('news') }}"><i class="fa fa-th"></i> @lang('messages.frontend-news') </a>
    </div>
    <ul>
        @php
        $parent_id = 0;
        $last_name = '';
        @endphp
        @foreach($newsCategories as $key => $category)
            @if ($key != 0 && $parent_id != $category->parent_id)
                @for( $i = 0; $i < substr_count($last_name, '&nbsp;&nbsp;&nbsp;&nbsp') - substr_count($category->name, '&nbsp;&nbsp;&nbsp;&nbsp'); $i++ )
    </ul></li>
    @endfor
    @endif
    {{--CÓ CON THÌ LUÔN MỞ--}}
    @if (count($category->children()) > 0)
        <li @if($categorySlug == $category->slug && $type == 'news') class="active" @endif>
            <a href="{{ route('news') }}?danh-muc={{ $category->slug }}"><i class="fa fa-angle-double-right"></i> {{ $category->name }} ({{ count($category->news) }})</a><span class="submenu-indicator"><i class="fa fa-plus"></i></span>
            <ul class="submenu" @if(in_array($category->slug,$parentArrayNews)) style="display: block" @endif>
                @php
                $parent_id = $category->id
                @endphp
                @endif

                @php $level = substr_count($category->name, '&nbsp;&nbsp;&nbsp;&nbsp;'); @endphp
                {{--KHÔNG CÓ CON THÌ TỰ ĐÓNG--}}
                @if (count($category->children()) == 0)
                    <li @if($categorySlug == $category->slug && $type == 'news') class="active" @endif>
                        <a href="{{ route('news') }}?danh-muc={{ $category->slug }}">
                            <i class="fa fa-angle-double-right"></i>{{ strlen($category->name)>(30+$level*24)? substr($category->name, 0, strpos($category->name,' ',25+$level*24)).'...' : $category->name }} ({{ count($category->news) }})
                        </a>
                    </li>
                    @php
                    $parent_id = $category->parent_id;
                    $last_name = $category->name;
                    @endphp
                @endif
                @endforeach
            </ul>
</div>

@foreach($banners as $banner)
    <article class="box">
        <figure>
            <a title="" href="{{ $banner->url? $banner->url : '#' }}" target="_blank">
                <img alt="" data-original="{{$banner->image}}" class="img-banner" style="width: 100%;">
            </a>
        </figure>
    </article>
@endforeach
