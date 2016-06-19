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
    .list-group-item{
        display: none;
    }
</style>
<nav class="navbar navbar-blue navbar-fixed-top">
    <div class="container">
        <div class="row">
            <div class="col-xs-3" style="line-height: 50px;">
                <a href="javascript:history.back(-1);"><i class="fa fa-angle-left" style="font-size: 1.5em;"></i></a>
            </div>
            <div class="col-xs-6 text-center" style="line-height: 50px;">
                编辑收款方式
            </div>
            <div class="col-xs-3 text-right" style="line-height: 50px;">
            </div>
        </div>
    </div>
</nav>
<div style="height: 55px;"></div>

<div class="container" style="padding: 0px;">
    <form id="frmBank">
        <ul class="list-group">
            <li class="list-group-item" style="display: block;">
                <div class="row" style="background-color: #fff; line-height: 30px;">
                    <div class="col-xs-3" style="padding-right: 0px;">
                        收款工具
                    </div>
                    <div class="col-xs-9">
                        <select class="form-control" id="payment_type" name="payment_type">
                            <option value="">请选择</option>
                            <option value="1">支付宝</option>
                            <option value="2">微信支付</option>
                            <option value="bank">银行卡</option>
                        </select>
                    </div>
                </div>
            </li>
            <li class="list-group-item" id="labBanks">
                <div class="row" style="background-color: #fff; line-height: 30px;">
                    <div class="col-xs-3" style="padding-right: 0px;">
                        银行
                    </div>
                    <div class="col-xs-9">
                        <select class="form-control" id="bank_id" id="bank_id">
                            <option value="">请选择</option>
                            <!--<option value="alipay">中国银行</option>
                            <option value="wxpay">工商银行</option>
                            <option value="bank">建设银行</option>
                            <option value="bank">农业银行</option>
                            <option value="bank">招商银行</option>
                            <option value="bank">平安银行</option>
                            <option value="bank">兴业银行</option>
                            <option value="bank">广发银行</option>
                            <option value="bank">民生银行</option>-->
                        </select>
                    </div>
                </div>
            </li>
            <li class="list-group-item" id="labBank">
                <div class="row" style="background-color: #fff; line-height: 30px;">
                    <div class="col-xs-3" style="padding-right: 0px;">
                        开户行
                    </div>
                    <div class="col-xs-9">
                        <input type="text" value="" placeholder="开户行名称" id="bank_name">
                    </div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="row" style="background-color: #fff; line-height: 30px;">
                    <div class="col-xs-3" style="padding-right: 0px;" id="labName">
                        户名
                    </div>
                    <div class="col-xs-9">
                        <input type="text" value="" placeholder="开户人姓名" id="account_name" name="account_name">
                    </div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="row" style="background-color: #fff; line-height: 30px;">
                    <div class="col-xs-3" style="padding-right: 0px;" id="labAccount">
                        账号
                    </div>
                    <div class="col-xs-9">
                        <input type="text" value="" placeholder="银行卡号" id="account" name="account">
                    </div>
                </div>
            </li>
        </ul>

        <div style="display: none;">
            <div class="alert alert-danger text-center" id="errorMsg">
            </div>
        </div>

        <div class="text-center">
            <a id="btnSave" class="btn btn-primary" style="width: 90%; display:none;"> 保存</a>
            <a id="btnBindWechat" class="btn btn-success" style="width: 90%; display: none;"><i class="fa fa-wechat"></i> 点击绑定微信</a>
        </div>
    </form>
</div>
<?php
$script = <<<js
js;

\Asset::js($script, [], 'before-script', true);
\Asset::js(['modules/store/default/finance/bank.js'], [], 'js-files', false);

?>