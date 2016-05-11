<style type="text/css">
    body{
        background-color: #efefef;
    }
    .navbar-blue{
        background-color: #337ab7;
        color: #fff;
    }
    .navbar-blue a{
        color: #fff;
    }
    input[type=text]{
        border: 0px;
        outline: none;
    }
</style>
<nav class="navbar navbar-blue navbar-fixed-top">
    <div class="container">
        <div class="row">
            <div class="col-xs-3" style="line-height: 50px;">
                <a href="javascript:history.back(-1);"><i class="fa fa-angle-left" style="font-size: 1.5em;"></i></a>
            </div>
            <div class="col-xs-6 text-center" style="line-height: 50px;">
                充值
            </div>
            <div class="col-xs-3 text-right" style="line-height: 50px;">
                <a href="/store/finance/cashback_records">明细</a>
            </div>
        </div>
    </div>
</nav>

<div class="list-group" style="margin-top: 55px; margin-bottom: 5px;">
    <div class="list-group-item">
        <div class="row" style="background-color: #fff; line-height: 40px;">
            <div class="col-xs-3" style="padding-right: 0px;">
                支付方式
            </div>
            <div class="col-xs-9">
                <select class="form-control">
                    <option value="wxpay">微信支付</option>
                    <option value="alipay">支付宝</option>
                </select>
            </div>
        </div>
    </div>
    <div class="list-group-item">
        <div class="row" style="background-color: #fff; line-height: 40px;">
            <div class="col-xs-3" style="padding-right: 0px;">
                充值金额
            </div>
            <div class="col-xs-9">
                <input type="text" value="" class="form-control" placeholder="请输入充值金额"/>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <p class="help-block">当前预存款余额 0.00</p>
    <div class="row">
        <div class="col-xs-12 text-center">
            <a class="btn btn-primary" style="width: 100%;">充值</a>
        </div>
    </div>
</div>

<?php
$script = <<<js
    var _balance = 0;
    var _account_id = 0;
js;

\Asset::js($script, [], 'before-script', true);

\Asset::js(['modules/store/default/finance/cashback.js'], [], 'js-files', false);
?>