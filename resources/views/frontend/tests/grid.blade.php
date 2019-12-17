<div class="row white-block" style="margin-left: 0px; margin-right: 0px; margin-top: 15px;">
    <h2 class="header-home"><a href="{{ route('tests') }}"><u>@lang('messages.frontend-home-test')</u></a></h2>
    <div class="hotel-list" id="test-container">
        <div id="test-row-{{ $row_test=0 }}">
            @foreach($tests as $key => $test)
                <div class="col-sm-6 col-md-2 item-padding">
                    <article class="box">
                        <figure>
                            <a href="{{ route('tests.show', $test->slug) }}" class="text-center"><img
                                        class="document-img-home" alt="{{ $test->slug }}"
                                        data-original="{{ $test->image }}"></a>
                        </figure>
                        <div class="details">
                            <h5 class="box-title text-center">
                                <a href="{{ route('tests.show', $test->slug) }}">{{ (\App\Helpers\Helper::subDescription($test->name,'', 45, false) ) }}</a>
                                <small><i class="fa fa-clock-o"></i> {{ $test->updated_at }}</small>
                                <small class="comment-views yellow-color"><i
                                            class="fa fa-eye"></i> {{ $test->view_counts }}
                                    / <i class="fa fa-comments-o"></i> {{ $test->comment_counts }}</small>
                            </h5>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</div>

@if($tests->hasPages())
    <div class="box-footer">
        {!! $tests->appends(['search' => Request::get('search'), 'mode' => 'grid', 'danh-muc'=>Request::get('danh-muc')])->render() !!}
    </div>
@endif