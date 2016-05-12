<style type="text/css">
    .navbar-blue{
        background-color: #337ab7;
    }
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

<?php if($client_type != 'wechat'){ ?>
    <nav class="navbar navbar-fixed-top navbar-blue">
        <div class="container-fluid">
            <div class="row" style="line-height: 50px; margin-left: 0px; margin-right: 0px;">
                <div class="col-xs-2">
                    <a href="javascript:history.back();">
                        <i class="fa fa-angle-left" style="font-size: 2em; color: #fff;"></i>
                    </a>
                </div>
                <div class="col-xs-8 text-center" style="color: #fff; font-size: 13pt; font-weight: 600;">
                    我的支付方式
                </div>
                <div class="col-xs-2 text-right">
                    <a href="/ucenter/finance/bank" style="font-size: 1.5em; color: #fff;"><i class="fa fa-plus"></i></a>
                </div>
            </div>
        </div>
    </nav>
<?php } ?>

<div style="height: 55px"></div>
<div class="container" style="padding: 0px 5px;">
    <?php if(isset($items) && $items){ ?>
        <?php foreach ($items as $item) { ?>
            <div class="alert alert-danger">
                <div class="row">
                    <div class="col-xs-2">
                        <img src="http://img.wdjimg.com/mms/icon/v1/9/9a/05a6f22315df13d74f7a41b0c7b6d9a9_256_256.png" alt="" style="width: 100%;"/>
                    </div>
                    <div class="col-xs-10">
                        <dl>
                            <dt><?php echo $item->bank->name;?></dt>
                            <dd><?php echo $item->account_name;?></dd>
                            <dd style="font-size: 2em;">
                                <?php echo $item->account; ?>
                                <!--<span>**** **** ****</span> 5136-->
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php }else{ ?>
        <div class="text-center">您还没有收款方式!</div>
    <?php } ?>

    <!--<div class="alert alert-danger">
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
    </div>-->
</div>

<?php
$script = <<<js
js;

\Asset::js($script, [], 'before-script', true);

\Asset::js(['modules/trade/default/user/pay.js'], [], 'js-files', false);
?>
