<div id="addMoneyModal" class="modal fade" role="dialog">
    <form method="POST" id="addMoneyForm">
        {{ csrf_field() }}
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    <h4 class="modal-title">@lang('messages.add_sub_money')</h4>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="form-group col-md-3">
                                <input class="minimal" type="radio" value="0" name="sign" checked>
                                <label>@lang('messages.add_money')</label>
                            </div>
                            <div class="form-group col-md-3">
                                <input class="minimal" type="radio" value="1" name="sign">
                                <label>@lang('messages.sub_money')</label>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group col-md-6">
                                <label>@lang('messages.transaction_unit_vnd')</label>
                                <input class="form-control" id="cost_vnd" name="cost_vnd"
                                       placeholder="@lang('messages.transactions_money_placeholder')" type="text">
                            </div>
                            <div class="form-group col-md-6">
                                <label>@lang('messages.transaction_unit_know')</label>
                                <input class="form-control" id="cost_know" required name="cost_know"
                                       placeholder="@lang('messages.transaction_placeholder_know')" type="text">
                            </div>
                            <div class="form-group col-md-12">
                                <label>@lang('messages.transaction_description')</label>
                                {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => __('messages.transactions_description')]) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i
                                class="glyphicon glyphicon-remove"></i> @lang('messages.comments_modal_close')
                    </button>
                    <button type="submit" class="btn btn-primary"><i
                                class="fa fa-save"></i> @lang('messages.save')
                    </button>
                </div>
            </div>

        </div>
    </form>
</div>