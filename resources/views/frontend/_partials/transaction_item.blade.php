@if($tran->content == \App\Helpers\Helper::$TRANS_RECHARGE)
    <div class="transaction_item">
        <div class="booking-info clearfix">
            <div class="date">
                <label class="month">Tháng {{ $tran->created_at->format('m') }}</label>
                <label class="date">{{ $tran->created_at->format('d') }}</label>
                <label class="day" style="padding-top: 3px;">{{ $tran->created_at->format('Y') }}</label>
            </div>
            <h4 class="box-title">
                <i class="icon glyphicon glyphicon-transfer takeoff-effect yellow-color circle"></i>
                <i class="fa fa-plus" aria-hidden="true"></i>
                {{ Helper::format_money($tran->money_transfer, true, ' KNOW') }}
                <small>{!! Helper::convertTransFields('content', $tran->content) !!} - {!! $tran->created_at !!}</small>
            </h4>
            <div class="pull-right" style="padding-top: 10px">
                <h5>{{ $tran->trans_payment_name }}</h5>
                <h5 style="text-align: right">{{ Helper::format_money($tran->real_value) }}</h5>
                <h5>{!! $tran->description !!}</h5>
            </div>
        </div>
    </div>
@elseif($tran->content == \App\Helpers\Helper::$TRANS_RECHARGE_CARD)
    <div class="transaction_item">
        <div class="booking-info clearfix">
            <div class="date">
                <label class="month">Tháng {{ $tran->created_at->format('m') }}</label>
                <label class="date">{{ $tran->created_at->format('d') }}</label>
                <label class="day" style="padding-top: 3px;">{{ $tran->created_at->format('Y') }}</label>
            </div>
            <h4 class="box-title">
                <i class="icon glyphicon glyphicon-transfer takeoff-effect yellow-color circle"></i>
                <i class="fa fa-plus" aria-hidden="true"></i>
                {{ Helper::format_money($tran->money_transfer,true,' KNOW') }}
                <small>{!! Helper::convertTransFields('content', $tran->content) !!} - {!! $tran->created_at !!}</small>
            </h4>
            <div class="pull-right" style="padding-top: 10px">
                <h5>{!! $tran->trans_card_type !!}</h5>
                <h5>{{ Helper::format_money($tran->real_value) }}</h5>
            </div>
        </div>
    </div>
@elseif($tran->content == \App\Helpers\Helper::$TRANS_COMMENT_DOC)
    <div class="transaction_item">
        <div class="booking-info clearfix">
            <div class="date">
                <label class="month">Tháng {{ $tran->created_at->format('m') }}</label>
                <label class="date">{{ $tran->created_at->format('d') }}</label>
                <label class="day" style="padding-top: 3px;">{{ $tran->created_at->format('Y') }}</label>
            </div>
            <h4 class="box-title">
                <i class="icon glyphicon glyphicon-transfer takeoff-effect yellow-color circle"></i>
                <i class="fa fa-minus" aria-hidden="true"></i>
                {{ Helper::format_money($tran->money_transfer,true,' KNOW') }}
                <small>{!! Helper::convertTransFields('content', $tran->content) !!} - {!! $tran->created_at !!}</small>
            </h4>
            <div class="pull-right" style="padding-top: 10px">
                @if(isset($tran->document))
                    <a href="{{ route('documents.show', $tran->document->slug) }}"><h5>{{ $tran->document->name }}</h5></a>
                @else
                    <h5>@lang('messages.transaction_undefined_document')</h5>
                @endif
            </div>
        </div>
    </div>
@elseif($tran->content == \App\Helpers\Helper::$TRANS_DOWNLOAD_DOC || $tran->content == \App\Helpers\Helper::$TRANS_DOWNLOAD_TEST)
    <div class="transaction_item">
        <div class="booking-info clearfix">
            <div class="date">
                <label class="month">Tháng {{ $tran->created_at->format('m') }}</label>
                <label class="date">{{ $tran->created_at->format('d') }}</label>
                <label class="day" style="padding-top: 3px;">{{ $tran->created_at->format('Y') }}</label>
            </div>
            <h4 class="box-title">
                <i class="icon glyphicon glyphicon-transfer takeoff-effect yellow-color circle"></i>
                <i class="fa fa-minus" aria-hidden="true"></i>
                {{ Helper::format_money($tran->money_transfer,true,' KNOW') }}
                <small>{!! Helper::convertTransFields('content', $tran->content) !!} - {!! $tran->created_at !!}</small>
            </h4>
            <div class="pull-right" style="padding-top: 10px">
                @if($tran->document_id!=0)
                    <a href="{{ route('documents.show', $tran->document->slug) }}"><h5>{{ $tran->document->name }}</h5></a>
                @elseif($tran->test_id!=0)
                    <a href="{{ route('tests.show', $tran->test->slug) }}"><h5>{{ $tran->test->name }}</h5></a>
                @else
                    @if($tran->content == \App\Helpers\Helper::$TRANS_DOWNLOAD_DOC)
                        <h5>@lang('messages.transaction_undefined_document')</h5>
                    @elseif($tran->content == \App\Helpers\Helper::$TRANS_DOWNLOAD_TEST)
                        <h5>@lang('messages.transaction_undefined_test')</h5>
                    @endif
                @endif
            </div>
        </div>
    </div>
@elseif($tran->content == \App\Helpers\Helper::$TRANS_VIEW_TUTORIAL)
    <div class="transaction_item">
        <div class="booking-info clearfix">
            <div class="date">
                <label class="month">Tháng {{ $tran->created_at->format('m') }}</label>
                <label class="date">{{ $tran->created_at->format('d') }}</label>
                <label class="day" style="padding-top: 3px;">{{ $tran->created_at->format('Y') }}</label>
            </div>
            <h4 class="box-title">
                <i class="icon glyphicon glyphicon-transfer takeoff-effect yellow-color circle"></i>
                <i class="fa fa-minus" aria-hidden="true"></i>
                {{ Helper::format_money($tran->money_transfer,true,' KNOW') }}
                <small>{!! Helper::convertTransFields('content', $tran->content) !!} - {!! $tran->created_at !!}</small>
            </h4>
            <div class="pull-right" style="padding-top: 10px">
                <h5>{{ $tran->tutorial? $tran->tutorial->title : '' }}</h5>
            </div>
        </div>
    </div>
@else
    <div class="transaction_item">
        <div class="booking-info clearfix">
            <div class="date">
                <label class="month">Tháng {{ $tran->created_at->format('m') }}</label>
                <label class="date">{{ $tran->created_at->format('d') }}</label>
                <label class="day" style="padding-top: 3px;">{{ $tran->created_at->format('Y') }}</label>
            </div>
            <h4 class="box-title">
                <i class="icon glyphicon glyphicon-transfer takeoff-effect yellow-color circle"></i>
                <i class="fa fa-minus" aria-hidden="true"></i>
                {{ Helper::format_money($tran->money_transfer,true,' KNOW') }}
                <small>{!! Helper::convertTransFields('content', $tran->content) !!} - {!! $tran->created_at !!}</small>
            </h4>

            <div class="pull-right" style="padding-top: 10px">
                <h5>{{ \App\Helpers\Helper::format_money($tran->real_value) }}</h5>
            </div>
        </div>
    </div>
@endif