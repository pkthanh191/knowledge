<div class="center">
    <h3>Yêu cầu nạp tiền</h3>
    <input class="button" type="button" id="btn_deposit" value="Nạp tiền" />
</div>
<script type="text/javascript" src="/frontend/js/nganluong.apps.mcflow.js"></script>
<script language="javascript">
    var mc_flow = new NGANLUONG.apps.MCFlow({trigger:'btn_deposit',url:'{{ $link_checkout }}}'});
</script>