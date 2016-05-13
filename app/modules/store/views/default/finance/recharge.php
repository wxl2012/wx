<style type="text/css">
    body{
        background-color: #efefef;
    }
    input[type=text], select{
        border: 0px;
        outline: none;
    }
    .alert{
        padding: 10px;
    }
    #errorMsg{
        margin-top: 0px;
    }
    .list-group .list-group-item:first-child{
        border-top-left-radius: 0px;
        border-top-right-radius: 0px;
    }
    .list-group .list-group-item:last-child{
        border-bottom-left-radius: 0px;
        border-bottom-right-radius: 0px;
    }
</style>

<div class="list-group" style="margin-top: 5px; margin-bottom: 5px;">
    <div class="list-group-item">
        <div class="row" style="background-color: #fff; line-height: 34px;">
            <div class="col-xs-3" style="padding-right: 0px;">
                支付方式
            </div>
            <div class="col-xs-9">
                <select class="form-control" id="payment">
                    <option value="wxpay">微信支付</option>
                    <option value="alipay">支付宝</option>
                </select>
            </div>
        </div>
    </div>
    <div class="list-group-item">
        <div class="row" style="background-color: #fff; line-height: 34px;">
            <div class="col-xs-3" style="padding-right: 0px;">
                充值金额
            </div>
            <div class="col-xs-9">
                <input type="text" id="money" value="" class="form-control" placeholder="请输入充值金额"/>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <p class="help-block">当前预存款余额 0.00</p>
    <div class="row">
        <div class="col-xs-12 text-center">
            <div class="alert alert-danger" style="margin-bottom: 10px; display: none;">
                <p class="help-block" id="errorMsg"></p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 text-center">
            <a class="btn btn-primary" id="btnSubmit" style="width: 100%;">充值</a>
        </div>
    </div>
</div>

<?php
$script = <<<js
    var _balance = 0;
    var _account_id = 0;
js;

\Asset::js($script, [], 'before-script', true);

\Asset::js(['modules/store/default/finance/recharge.js'], [], 'js-files', false);
?>