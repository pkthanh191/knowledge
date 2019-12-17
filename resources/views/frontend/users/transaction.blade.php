<div id="booking" class="tab-pane fade">
    <div style="padding-bottom: 15px">
        <h2 style="display: inline">@lang('messages.frontend_transaction_history')</h2>
        <h3 class="pull-right">{{ \App\Helpers\Helper::format_money(Auth::user()->account_balance, true, ' KNOW') }}</h3>
    </div>
    <div class="filter-section gray-area clearfix">
        <form method="get">
            <label class="radio radio-inline">
                <input type="radio" id="trans-0" name="trans" value="0" checked="checked"/>
                @lang('messages.frontend-all')
            </label>
            {{--<label class="radio radio-inline">
                <input type="radio" id="trans-1" name="trans" value="1"/>
                @lang('messages.frontend-recharge')
            </label>
            <label class="radio radio-inline">
                <input type="radio" id="trans-2" name="trans" value="2"/>
                @lang('messages.frontend-recharge-card')
            </label>--}}
            <label class="radio radio-inline">
                <input type="radio" id="trans-3" name="trans" value="3"/>
                @lang('messages.frontend-post-comment')
            </label>
            <label class="radio radio-inline">
                <input type="radio" id="trans-4" name="trans" value="4"/>
                @lang('messages.transaction_download')
            </label>
            <label class="radio radio-inline">
                <input type="radio" id="trans-6" name="trans" value="6">
                @lang('messages.transactions_content_'.\App\Helpers\Helper::$TRANS_VIEW_TUTORIAL)
            </label>
            <div class="pull-right col-md-6 action">
            {{--<h5 class="pull-left no-margin col-md-4">Sắp xếp theo:</h5>--}}
            {{--<button class="btn-small white gray-color">Tăng dần</button>--}}
            {{--<button class="btn-small white gray-color">Giảm dần</button>--}}
            </div>
        </form>
    </div>
    <div class="booking-history">
        @if (count($transactions) == 0)
            <div id="no-transaction">@lang('messages.frontend_no_transaction')</div>
        @else
            <div id="transaction_list">
            </div>
            <div id="transaction-tab-0">
                @foreach($transactions as $key => $tran)
                    @include('frontend._partials.transaction_item')
                @endforeach
                @if(count($transactions) > 5 )
                    <button id="loadMoreTrans-0" class="btn-large full-width">@lang('messages.frontend_load_more')</button>
                @endif
            </div>
        @endif
    </div>

    @foreach([1,2,3,[4,5],6] as $content)
        <div id="transaction-tab-{{ is_array($content)? $content[0] : $content }}" style="display: none">
            @php $count=0 @endphp
            @foreach($transactions as $tran)
                @if($tran->content == $content || (is_array($content) && in_array($tran->content,$content) ))
                    @include('frontend._partials.transaction_item')
                    @php $count++ @endphp
                @endif
            @endforeach
            @if($count == 0)
                <div class="text-center">@lang('messages.frontend_no_transaction') </div>
            @elseif($count>5)
                <button id="loadMoreTrans-{{ is_array($content)? $content[0] : $content }}" class="btn-large full-width">@lang('messages.frontend_load_more')</button>
            @endif
        </div>
    @endforeach
</div>