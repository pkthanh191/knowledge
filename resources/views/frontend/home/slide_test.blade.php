<div class="row white-block-list">
    <h2 class="header-home-list">
        <a href="{{ route('tests') }}" class="uppercase">@lang('messages.frontend-home-test')</a>
    </h2>
</div>
<div class="row hotel-list listing-style3 hotel">
    @foreach($tests as $key => $test)
        @include('frontend._partials.test_list_item')
    @endforeach
</div>
<div class="row text-right">
    <a class="button btn-small text-center" style="margin-bottom: 15px;" title="" href="{{ route('tests') }}"> > Xem thêm</a>
</div>

{{--
<div class="row white-block">
    <h2 class="header-home"><a href="{{ route('tests') }}" class="uppercase">@lang('messages.frontend-home-test')</a></h2>
    <hr>

    <div class="hotel-list" id="test-container">
        <div id="test-row-{{ $row_test=0 }}">
            @foreach($tests as $key => $test)
                <div class="col-sm-6 col-md-2 item-padding">
                    <article class="box">
                        <figure>
                            <a href="{{ route('tests.show', $test->slug) }}" class="text-center"><img
                                        class="document-img-home" alt="{{ $test->slug }}"
                                        data-original="/public/{{ $test->image }}"></a>
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
                @if(($key+1)%6==0 && $key!=count($tests)-1)
        </div>
        <div id="test-row-{{ ++$row_test }}" style="{{ $row_test>1? "display: none" : "" }}">
            @endif
            @endforeach
        </div>
        <div class="clearfix"></div>
        @if(count($tests)>12)
            <div class="text-center"><a id="loadMoreHomeTest" href="javascript:;" class="button btn-small">@lang('messages.frontend_load_more') ↓</a></div>
        @endif
    </div>
</div>--}}
