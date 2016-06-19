<style type="text/css">
    body{
        background-color: #efefef;
    }
    dl{
        margin: 0px;
    }
    .alert{
        padding: 10px;
        color: #fff;
        background-color: #b94a48;
        margin-bottom: 3px;
    }
    .alert .row .col-xs-2{
        padding-right: 0px;
    }
    .alert .row .col-xs-10{
        padding-left: 10px;
    }
</style>

<div class="container" style="margin-top: 5px; padding: 0px 5px;">
    <div class="alert alert-danger">
        <div class="row">
            <div class="col-xs-2">
                <img src="http://img.wdjimg.com/mms/icon/v1/9/9a/05a6f22315df13d74f7a41b0c7b6d9a9_256_256.png" alt="" style="width: 100%;"/>
            </div>
            <div class="col-xs-10">
                <dl>
                    <dt>招商银行</dt>
                    <dd>储蓄卡</dd>
                    <dd style="font-size: 2em;">
                        <span>**** **** ****</span> 5136
                    </dd>
                </dl>
            </div>
        </div>
    </div>
    <div class="alert alert-danger">
        <div class="row">
            <div class="col-xs-2">
                <img src="/assets/img/alipay.jpg" alt="" style="width: 100%;"/>
            </div>
            <div class="col-xs-10">
                <dl>
                    <dt>支付宝</dt>
                    <dd>收款帐户</dd>
                    <dd>ku***@sina.com</dd>
                </dl>
            </div>
        </div>
    </div>
    <div class="alert alert-danger">
        <div class="row">
            <div class="col-xs-2">
                <img src="/assets/img/wxpay.png" alt="" style="width: 100%;"/>
            </div>
            <div class="col-xs-10">
                <dl>
                    <dt>微信支付</dt>
                    <dd>收款帐户</dd>
                    <dd>orm_alek123i838749kdh</dd>
                </dl>
            </div>
        </div>
    </div>
</div>

<?php
$script = <<<js
js;

\Asset::js($script, [], 'before-script', true);

\Asset::js(['modules/store/default/finance/banks.js'], [], 'js-files', false);
?>
