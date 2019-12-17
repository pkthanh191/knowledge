<div class="jquery-accordion-menu white">
    <div class="jquery-accordion-menu-header uppercase">
        <a href="{{ route('documents') }}"><i class="fa fa-th"></i> @lang('messages.frontend-doc-categories')</a>
    </div>
    <ul>
        @php
            $parent_id = 0;
            $last_name = '';
        @endphp
        @foreach($docCategories as $key => $category)
            @if ($key != 0 && $parent_id != $category->parent_id)
                @for( $i = 0; $i < substr_count($last_name, '&nbsp;&nbsp;&nbsp;&nbsp;') - substr_count($category->name, '&nbsp;&nbsp;&nbsp;&nbsp;'); $i++ )
    </ul>
    </li>
    @endfor
    @endif
    @php $level = substr_count($category->name, '&nbsp;&nbsp;&nbsp;&nbsp;') @endphp
    {{--CÓ CON THÌ LUÔN MỞ--}}
    @if (count($category->children()) > 0)
        <li @if($categorySlug == $category->slug && $type == 'documents') class="active" @endif>
            <a href="{{ route('documents') }}?danh-muc={{ $category->slug }}"><i
                        class="fa fa-angle-double-right"></i> {!! strlen($category->name)-$level*24>25? substr($category->name, 0, strpos($category->name,' ',25+$level*24)).'...' :$category->name !!} ({{ count($category->documents) }})</a>
            <span class="submenu-indicator"><i class="fa fa-plus"></i></span>
            <ul class="submenu" @if((in_array($category->slug,$parentArrayDoc))) style="display: block" @endif>
                @php
                    $parent_id = $category->id
                @endphp
                @endif

                {{--KHÔNG CÓ CON THÌ TỰ ĐÓNG--}}
                @if (count($category->children()) == 0)
                    <li @if($categorySlug == $category->slug && $type == 'documents') class="active" @endif>
                        <a href="{{ route('documents') }}?danh-muc={{ $category->slug }}"><i
                                    class="fa fa-angle-double-right"></i>{!! strlen($category->name)>30+$level*24? substr($category->name, 0, strpos($category->name,' ',30+$level*24)).'...' : $category->name !!} ({{ count($category->documents) }})</a>
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
    <a href="{{ route('tests') }}">
        <div class="jquery-accordion-menu-header uppercase"><i
                    class="fa fa-th"></i> @lang('messages.frontend-test-categories')</div>
    </a>
    <ul>
        @php
            $parent_id = 0;
            $last_name = '';
        @endphp
        @foreach($testCategories as $key => $category)
            @if ($key != 0 && $parent_id != $category->parent_id)
                @for( $i = 0; $i < substr_count($last_name, '&nbsp;&nbsp;&nbsp;&nbsp') - substr_count($category->name, '&nbsp;&nbsp;&nbsp;&nbsp'); $i++ )
    </ul>
    </li>
    @endfor
    @endif
    @php $level = substr_count($category->name, '&nbsp;&nbsp;&nbsp;&nbsp;'); @endphp
    {{--CÓ CON THÌ LUÔN MỞ--}}
    @if (count($category->children()) > 0)
        <li @if($categorySlug == $category->slug && $type == 'tests') class="active" @endif>
            <a href="{{ route('tests') }}?danh-muc={{ $category->slug }}"><i
                        class="fa fa-angle-double-right"></i> {{ strlen($category->name)>25+$level*24? substr($category->name, 0, strpos($category->name,' ',25+$level*24)).'...' : $category->name }} ({{ count($category->test) }})</a>
            <span class="submenu-indicator"><i class="fa fa-plus"></i></span>
            <ul class="submenu">
                @php
                    $parent_id = $category->id
                @endphp
                @endif

                {{--KHÔNG CÓ CON THÌ TỰ ĐÓNG--}}
                @if (count($category->children()) == 0)
                    <li @if($categorySlug == $category->slug && $type == 'tests') class="active" @endif>
                        <a href="{{ route('tests') }}?danh-muc={{ $category->slug }}"><i
                                    class="fa fa-angle-double-right"></i>{{ strlen($category->name)>30+$level*24? substr($category->name, 0, strpos($category->name,' ',30+$level*24)).'...' : $category->name }} ({{ count($category->test) }})</a>
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
    <div class="jquery-accordion-menu-header uppercase">
        <a href="{{ route('centers') }}"><i class="fa fa-th"></i> @lang('messages.frontend-center-categories') </a>
    </div>
    <ul>
        <li @if($type == 'centers') class="active" @endif><a href="{{ route('centers') }}"><i
                        class="fa fa-angle-double-right"></i> @lang('messages.frontend-centers') ({{$centerCount - 1}})</a>
        </li>
        <li @if($type == 'teachers') class="active" @endif><a href="{{ route('teachers') }}"><i
                        class="fa fa-angle-double-right"></i> @lang('messages.frontend-teachers') ({{$teacherCount - 1}}
                )</a></li>
        <li @if($type == 'courses') class="active" @endif><a href="{{ route('courses') }}"><i
                        class="fa fa-angle-double-right"></i> @lang('messages.frontend-courses') ({{$courseCount}})</a>
        </li>
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
