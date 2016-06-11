<style type="text/css">
    #menuItems{
        color: #aaa;
    }
    .list-group-item:first-child{
        border-top-left-radius: 0px;
        border-top-right-radius: 0px;
    }
    .list-group-item:last-child{
        border-top-left-radius: 0px;
        border-top-right-radius: 0px;
    }
</style>

<div class="container-fluid">
    <div class="list-group">
        <div class="list-group-item">
            <div class="row">
                <div class="col-xs-12">
                    清单
                </div>
            </div>
        </div>
        <div class="list-group-item" id="menuItems">
            <div class="row">
                <div class="col-xs-6">
                    菜品
                </div>
                <div class="col-xs-3 text-center">
                    单价
                </div>
                <div class="col-xs-3 text-center" style="padding-left: 0px">
                    数量
                </div>

            </div>

        </div>
        <div class="list-group-item">
            <div class="row">
                <div class="col-xs-12 text-right">
                    合计: ￥<span id="total_fee"></span>元
                </div>
            </div>
        </div>
    </div>

    <div id="btns" class="row" style="padding-bottom: 20px;">
        <div class="col-xs-12 text-center">
            <a id="btnPay" class="btn btn-primary" style="width: 90%;">立即下单</a>
        </div>
        <div class="col-xs-12 text-center" style="padding-top: 5px;">
            <img src="/assets/img/wxpay.png" alt="" style="width: 15px;" />
            <span style="color: #aaa;">微信支付</span>
            <a href="javascript:;" id="btnChangePayment">更换</a>
        </div>
    </div>

    <div class="list-group" id="payments" style="display: none;">
        <div class="list-group-item">
            <div class="row">
                <div class="col-xs-12">
                    支付方式
                </div>
            </div>
        </div>
        <div class="list-group-item">
            <div class="row">
                <div class="col-xs-1" style="padding-right: 0px; line-height: 45px;">
                    <input type="radio" name="payment" value="wxpay" checked/>
                </div>
                <div class="col-xs-3">
                    <img src="/assets/img/wxpay.png" alt="" style="width: 100%;" />
                </div>
                <div class="col-xs-8" style="padding-left: 0px;">
                    <p>微信支付</p>
                    <p style="color: #e0e0e0;">推荐开通微信支付的用户使用</p>
                </div>
            </div>
        </div>
        <div class="list-group-item">
            <div class="row">
                <div class="col-xs-1" style="padding-right: 0px; line-height: 45px;">
                    <input type="radio" name="payment" value="alipay"/>
                </div>
                <div class="col-xs-3">
                    <img src="/assets/img/alipay.jpg" alt="" style="width: 100%;" />
                </div>
                <div class="col-xs-8" style="padding-left: 0px;">
                    <p>微信支付</p>
                    <p style="color: #e0e0e0;">推荐开通支付宝的用户使用</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/x-jquery-tmpl" id="dishItem">
    <div class="row" data-id="${goods_id}" data-name="${name}" data-price="${price}">
        <div class="col-xs-6">
            ${name}
        </div>
        <div class="col-xs-3 text-center" style="line-height: 26px">
            ${price}
        </div>
        <div class="col-xs-3 text-center" style="padding-left: 0px; color: #333;">
            <span role="minus" style="font-size:15pt;">-</span>
            <label class="text-center" style="width: 30px;">${num}</label>
            <input type="text" class="text-center" value="${num}" role="number" style="width:40px; display:none;">
            <span role="plus" style="font-size:15pt;">+</span>
        </div>
    </div>
</script>

<?php
$user_id = \Auth::check() ? \Auth::get_user()->id : 0;
$script = <<<js
    var _access_token = '';
    var _user_id = {$user_id};
    var _dish_list = [];
js;

\Asset::js($script, [], 'before-script', true);
\Asset::js(['tools.js', 'jquery-tmpl/jquery.tmpl.min.js', 'jquery-tmpl/jquery.tmplPlus.min.js', 'icheck/icheck.min.js', 'modules/restaurant/default/trolley/index.js'], [], 'js-files', false);
\Asset::css(['icheck/skins/square/blue.css'], [], 'css-files', false);
?>