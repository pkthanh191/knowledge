<div class="row white-block" style="margin-left: 0px; margin-right: 0px; margin-top: 15px;">
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
            @endforeach
        </div>
    </div>
</div>

@if($teachers->hasPages())
    <div class="box-footer">
        {!! $teachers->appends(['search' => Request::get('search'), 'mode' => 'grid', 'danh-muc'=>Request::get('danh-muc')])->render() !!}
    </div>
@endif