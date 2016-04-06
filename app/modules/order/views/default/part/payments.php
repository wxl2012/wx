<?php
$seller = \Session::get('seller', false);
if( ! isset($seller->open_payment) || ! $seller->open_payment){
    return;
}
?>
<div class="container-fluid">
    <div class="title">
        <span class="line_orange"></span>
        支付方式
    </div>
    <ul class="list-group" id="payment">
        <li class="list-group-item text-center">
            <i class="fa fa-spinner fa-spin"></i> 支付方式加载中...
        </li>
    </ul>
</div>

<script type="text/x-jquery-tmpl" id="paymentItem">
    <li class="list-group-item">
        <input type="radio" id="payment_${id}" name="payment_id" value="${id}"/>
        <label style="padding-left: 10px;" for="payment_${id}">${name}</label>
    </li>
</script>

<?php
    \Asset::js('order/default/part/payments.js', [], 'js-files', false);
?>