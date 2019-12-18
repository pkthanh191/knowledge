<div class="box white-block">
    <div class="suggestions image-carousel style2 relative" data-animation="slide" data-item-width="150" data-item-margin="22">
        <ul class="slides">
            @foreach($courses as $key => $course)
                <li>
                    <a href="{{ route('courses.show', $course->slug) }}">
                        <img data-original="/public/{{ $course->image }}" alt="{{ $course->slug }}" class="middle-item img-course"/>
                    </a>
                    <h5 class="caption">
                        <a href="{{ route('courses.show', $course->slug) }}">
                            {{ $course->name }}
                        </a>
                    </h5>
                </li>
            @endforeach
        </ul>
    </div>
</div>