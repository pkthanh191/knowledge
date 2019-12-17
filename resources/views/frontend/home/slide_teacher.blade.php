<div class="row white-block">
    <h2 class="header-home">
        <a href="{{ route('teachers') }}" class="uppercase">@lang('messages.frontend-home-teacher')</a>
    </h2>
    <hr>
    <div class="hotel-list" id="teacher-container">
        <div id="teacher-row-{{ $row_teacher=0 }}">
            @foreach($teachers as $key => $teacher)
                <div class="col-sm-6 col-md-2 item-padding">
                    <article class="box">
                        <figure>
                            <a href="{{ route('teachers.show', $teacher->slug) }}" class="text-center"><img class="document-img-home-center" alt="{{ $teacher->slug }}" data-original="{{ $teacher->image }}"></a>
                        </figure>
                        <div class="details">
                            <h5 class="box-title text-center">
                                <a href="{{ route('teachers.show', $teacher->slug) }}">{{ (\App\Helpers\Helper::subDescription($teacher->name,'',45, false) )}}</a>
                            </h5>
                        </div>
                    </article>
                </div>
                @if(($key+1)%6 == 0 && $key != count($teachers)-1)
        </div>
        <div id="teacher-row-{{ ++$row_teacher }}" style="{{ $row_teacher > 0 ? "display: none" : "" }}">
            @endif
            @endforeach
        </div>
        <div class="clearfix"></div>
        @if(count($teachers)> 6)
            <div class="text-center"><a id="loadMoreHomeTeacher" href="javascript:;" class="button btn-small">@lang('messages.frontend_load_more') ↓ </a></div>
        @endif
    </div>
</div>