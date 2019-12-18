<div class="modal fade" id="modal-recharge" style="display: none;">
    <form id="modal_nap_the" action="{{ route('recharge') }}" method="post">
        {{ csrf_field() }}
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">@lang('messages.frontend-recharge-card') <small class="required">(@lang('messages.frontend_choose_type_card'))</small></h4>
                </div>
                <div class="modal-body">
                    <p style="color: red" id="flash_error"></p>
                    <table align="center">
                        <tr>
                            <td colspan="2">
                                <table class="input-form-recharge">
                                    <tr>
                                        <td style="padding-left:0px;padding-top:5px" align="right" ><label for="92"><img  src="/public/uploads/mobifone.jpg" /></label> </td>
                                        <td style="padding-left:10px;padding-top:5px"><label for="93"><img  src="/public/uploads/vinaphone.jpg" /></label></td>
                                        <td style="padding-top:5px;padding-left:5px" align="left"><label for="107"><img  src="/public/uploads/viettel.jpg" width="110" height="35" /></label></td>
                                        <td style="padding-top:5px;padding-left:5px" align="left"><label for="121"><img width="100" height="35" src="/public/uploads/vtc.jpg"></label> </td>
                                        <td style="padding-top:5px;padding-left:5px" align="left"> <label for="120"><img width="100" height="35" src="/public/uploads/gate.jpg"></label></td>
                                    </tr>
                                    <tr>
                                        <td align="center">
                                            <input type="radio" name="select_method" checked="true" value="VMS" id="92"  />
                                        </td>
                                        <td align="center" style="padding-bottom:0px;padding-left:5px">
                                            <input type="radio"  name="select_method" value="VNP" id="93" />
                                        </td>
                                        <td align="center" style="padding-bottom:0px;padding-right:0px">
                                            <input type="radio"  name="select_method" value="VIETTEL" id="107" />
                                        </td>
                                        <td align="center" style="padding-right:10px">
                                            <input type="radio" id="121" value="VCOIN" name="select_method">
                                        </td>

                                        <td align="center" style="padding-bottom:0px;padding-right:0px">
                                            <input type="radio" id="120" value="GATE" name="select_method">
                                        </td>

                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <div id="loading"></div>
                        <tr>
                            <td align="right" width="35%">@lang('messages.frontend_seri_number') (<span class="required">*</span>):</td>
                            <td><input class="form-control input-form-recharge" type="text" id="serial" name="serial" style="height:25px;width:200px" placeholder="@lang('messages.frontend_serial_placeholder')" /></td>
                        </tr>
                        <tr>
                            <td align="right">@lang('messages.frontend_code_number') (<span class="required">*</span>): </td>
                            <td>
                                <input class="form-control input-form-recharge" type="text" id="pin" name="pin" style="height:25px;width:200px" placeholder="@lang('messages.frontend_pin_placeholer')" />
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="ttNganluong" name="NLNapThe" class="button btn-small">@lang('messages.frontend-recharge-card')</button>
                    <button type="button" id="cancel" class="button btn-small btn-cancel" data-dismiss="modal">@lang('messages.cancel')</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
        @if(!Auth::check())
        <input type="hidden" class="tutorial_id" name="tutorial_id" value="">
        <input type="hidden" class="info_email" name="info_email" value="">
        <input type="hidden" class="info_phone" name="info_phone" value="">
        @endif
        @if(Request::is('*nguoi-dung*'))
            <input type="hidden" class="inner_user" name="inner_user" value="true">
        @endif
    </form>
</div>