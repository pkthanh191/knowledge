<div class="jquery-accordion-menu white">
    <div class="jquery-accordion-menu-header uppercase"><i class="fa fa-th"></i> @lang('messages.frontend-course-categories') </div>
    <ul>
        @php
            $parent_id = 0;
            $last_name = '';
        @endphp
        @foreach($courseCategories as $key => $category)
            @if ($key != 0 && $parent_id != $category->parent_id)
                @for( $i = 0; $i < substr_count($last_name, '&nbsp;&nbsp;&nbsp;&nbsp') - substr_count($category->name, '&nbsp;&nbsp;&nbsp;&nbsp'); $i++ )
    </ul></li>
    @endfor
    @endif
    {{--CÓ CON THÌ LUÔN MỞ--}}
    @if (count($category->children()) > 0)
        <li @if($categorySlug == $category->slug && $type == 'courses') class="active" @endif>
            <a href="{{ route('courses') }}?danh-muc={{ $category->slug }}"><i class="fa fa-angle-double-right"></i> {{ $category->name }} ({{ count($category->courses) }})</a><span class="submenu-indicator"><i class="fa fa-plus"></i></span>
            <ul class="submenu">

                @php
                    $parent_id = $category->id
                @endphp
                @endif

                {{--KHÔNG CÓ CON THÌ TỰ ĐÓNG--}}
                @if (count($category->children()) == 0)
                    <li @if($categorySlug == $category->slug && $type == 'courses') class="active" @endif>
                        <a href="{{ route('courses') }}?danh-muc={{ $category->slug }}"><i class="fa fa-angle-double-right"></i>{{ $category->name }} ({{ count($category->courses) }})</a>
                    </li>
                    @php
                        $parent_id = $category->parent_id;
                        $last_name = $category->name;
                    @endphp
                @endif
                @endforeach
            </ul>
</div>
<div class="jquery-accordion-menu white">
    <div class="jquery-accordion-menu-header uppercase"><i class="fa fa-th"></i> @lang('messages.frontend-center-categories') </div>
    <ul>
        <li @if($type == 'centers') class="active" @endif><a href="{{ route('centers') }}"><i class="fa fa-angle-double-right"></i> @lang('messages.frontend-centers') ({{$centerCount - 1}})</a></li>
        <li @if($type == 'teachers') class="active" @endif><a href="{{ route('teachers') }}"><i class="fa fa-angle-double-right"></i> @lang('messages.frontend-teachers') ({{$teacherCount - 1}})</a></li>
        <li @if($type == 'courses') class="active" @endif><a href="{{ route('courses') }}"><i class="fa fa-angle-double-right"></i> @lang('messages.frontend-courses') ({{ $courseCount }})</a></li>
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
