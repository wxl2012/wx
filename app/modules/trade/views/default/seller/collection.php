<style type="text/css">
    .navbar-blue{
        background-color: #337ab7;
    }
    .row .col-xs-3{
        padding-right: 0px;
    }
    .list-group-item:first-child{
        border-top-left-radius: 0px;
        border-top-right-radius: 0px;
    }
    .list-group-item:last-child{
        border-bottom-left-radius: 0px;
        border-bottom-right-radius: 0px;
    }
    .navbar{
        margin-bottom: 0px;
    }
    .list-group-item .row .col-xs-3:first-child{
        line-height: 30px;
    }
    body{
        background-color: #efefef;
    }
</style>

<?php if($client_type != 'wechat'){ ?>
<nav class="navbar navbar-blue">
    <div class="container-fluid">
        <div class="row" style="line-height: 50px; margin-left: 0px; margin-right: 0px;">
            <div class="col-xs-2">
                <a href="javascript:history.back();">
                    <i class="fa fa-angle-left" style="font-size: 2em; color: #fff;"></i>
                </a>
            </div>
            <div class="col-xs-8 text-center" style="color: #fff; font-size: 13pt; font-weight: 600;">
                收款
            </div>
            <div class="col-xs-2">
            </div>
        </div>
    </div>
</nav>
<?php } ?>

<div class="container">
    <div class="row">
        <div class="col-xs-12" style="padding-top: 15px;">
            <ul class="list-group">

                <?php echo \Form::csrf();?>

                <li class="list-group-item">
                    <div class="text-center">
                        请使用微信扫一扫
                    </div>
                    <div>
                        <img src="/common/qrcode/generate?content=http://cn.bing.com" alt="" style="width: 100%;"/>
                    </div>
                </li>
            </ul>
        </div>
        <div class="col-xs-12">
            <select class="form-control">
                <option value="">请选择收款方式</option>
                <option>微信支付</option>
                <option>积分支付</option>
            </select>
        </div>
        <div class="col-xs-12 text-center" style="margin-top: 10px;">
            <input type="number" class="form-control text-center" placeholder="请填写收款金额" value="<?php echo isset($order) ? $order['total_fee'] : '';?>" />
        </div>
        <div class="col-xs-12 text-center" style="padding-top: 10px;">
            <textarea class="form-control" placeholder="收款理由"><?php echo isset($order) ? $order['remark'] : '';?></textarea>
        </div>


        <div class="col-xs-12 text-center" style="padding-top: 10px;">
            <a class="btn btn-warning" style="width: 100%;" id="btnSubmit">开始收款</a>
        </div>
    </div>
</div>


<?php
$script = <<<js
js;

\Asset::js($script, [], 'before-script', true);

\Asset::js(['modules/trade/default/seller/collection.js'], [], 'js-files', false);
?>
