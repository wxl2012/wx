<style type="text/css">
    .orange {
        color: #f39800;
    }

    .title{
        height: 40px;
        padding-left: 3%;
        line-height: 40px;
        background: #f7f7f7;
        border-top: #dadada solid 1px;
        clear: both;
        font-size: 16px;
    }

    .line_orange {
        width: 3px;
        height: 18px;
        background: #f39800;
        display: inline-block;
        position: relative;
        top: 3px;
        margin-right: 8px;
    }
    .remark{
        margin-top:1px;
        overflow: hidden;
        word-wrap: break-word;
        border: none;
        line-height: 20px;
        min-height: 100px;
        padding: 1% 0 0 1%;
    }
    #bill{
        position: fixed;
        bottom: 44px;
        width: 100%;
        margin-bottom: 0px;
    }
    #bill .list-group-item{
        background: #e9eef7;
    }
    .bill-title{
        line-height: 44px;
        background: #3d5a83;
        color: #fff;
        font-size: 18px;
    }
    .bill-field{
        font-size: 16px;
        color: #173257;
    }
    .bill-field span{
        color: #8b8b8b;
        font-size: 10px;
    }
</style>

<?php echo render('default/part/address'); ?>
<?php echo render('default/part/goods'); ?>
<?php echo render('default/part/coupons'); ?>
<?php echo render('default/part/payments'); ?>

<div class="container-fluid">
    <div class="title">
        <span class="line_orange"></span>
        备注
    </div>
    <textarea class="form-control remark" placeholder="请填写备注信息"></textarea>
</div>

Ajax创建订单<br>
微信支付时,本页调用支付页面<br>
支付宝支付时,跳转至支付宝支付页面并开始支付;显示右上角浏览器中打开<br>


<div class="list-group" id="bill">
    <div class="list-group-item" style="padding: 0px;">
        <div class="row">
            <div class="col-xs-12 bill-title text-center">
                我的账单
            </div>
        </div>
    </div>
    <div class="list-group-item">
        <div class="row">
            <div class="col-xs-9 bill-field">
                总金额<span>（<em>0</em>件商品<em>0</em>元）</span>
            </div>
            <div class="col-xs-3 text-right" style="color: #f39800" id="totalFee">
                0
            </div>
        </div>
    </div>
    <div class="list-group-item">
        <div class="row">
            <div class="col-xs-9 bill-field">
                优惠金额
                <span>（使用优惠券/码）</span>
            </div>
            <div class="col-xs-3 text-right" style="color: #72a94a" id="couponFee">
                0
            </div>
        </div>
    </div>
    <div class="list-group-item">
        <div class="row">
            <div class="col-xs-9 bill-field">
                积分抵扣
                <span>（使用积分）</span>
            </div>
            <div class="col-xs-3 text-right" style="color: #72a94a" id="scoreFee">
                0
            </div>
        </div>
    </div>
    <div class="list-group-item">
        <div class="row">
            <div class="col-xs-9 bill-field">
                红包金额
                <span>（使用礼金）</span>
            </div>
            <div class="col-xs-3 text-right" style="color: #72a94a" id="giftFee">
                0
            </div>
        </div>
    </div>
    <div class="list-group-item">
        <div class="row">
            <div class="col-xs-9 bill-field">
                应付金额
                <span>（实际应支付金额）</span>
            </div>
            <div class="col-xs-3 text-right" style="color: #f39800" id="originalFee">
                0
            </div>
        </div>
    </div>
</div>

<div style="height: 50px;"></div>

<nav class="navbar navbar-fixed-bottom" style="min-height: 44px; background: url(/assets/img/btm_bg.jpg) no-repeat;background-size: 100%;">
    <div class="container">
        <div class="row">
            <div class="col-xs-7" style="line-height: 44px; color: #676767; font-size:15px; padding-left: 5px; padding-right: 0px;">
                合计: <span class="orange">￥</span>
                <span id="originalMoney" class="orange">0</span>
                <a id="btnOpenBill" style="padding-left: 2px; color: #676767; text-decoration: none" href="javascript:;">[明细]</a>
            </div>
            <div class="col-xs-5 text-right" id="btnPay" style="line-height: 44px; color: #fff;">
                同意条款并支付
            </div>
        </div>
    </div>
</nav>

<?php
$script = <<<js
    var _access_token = '{$token}';
    var _order_name = '';
    var _order_body = '';
    var _total_fee = 0;
    var _original_fee = 0;
    var _preferential_fee = 0;
    var _order_type = '';
    var _address_id = 0;
    var _payment_id = 0;
    var _preferential = [];
js;

    \Asset::js($script, [], 'before-script', true);
    \Asset::js(['tools.js', 'icheck/icheck.min.js', 'jquery-tmpl/jquery.tmpl.min.js', 'jquery-tmpl/jquery.tmplPlus.min.js', 'order/default/create.js'], [], 'js-files', false);

    \Asset::css(['icheck/skins/flat/orange.css', 'font-awesome/4.5.0/css/font-awesome.min.css'], [], 'css-files', false);
?>