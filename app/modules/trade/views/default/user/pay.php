<style type="text/css">
    .navbar-blue{
        background-color: #337ab7;
    }
    .list-group-item:first-child{
        border-top-left-radius: 0px;
        border-top-right-radius: 0px;
    }
    .list-group-item:last-child{
        border-bottom-left-radius: 0px;
        border-bottom-right-radius: 0px;
    }
    .help-block{
        margin-bottom: 0px;
        font-size: 9pt;
        color: #c20202;
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
                    付款
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

                        <img src="/common/qrcode/generate?content=<?php echo \Config::get('base_url') . "trade/seller/create?" . (isset($key) ? "id={$key}" : "buyer_id={$user->id}");?>" alt="" style="width: 100%;" id="imgQrcode"/>
                    </div>
                </li>
            </ul>
        </div>

        <div class="col-xs-12 text-center input-panel">
            <input type="number" class="form-control text-center" placeholder="请填写付款金额" id="txtFee" name="fee" <?php echo isset($key) ? 'style="display:none;"' : '';?>/>
            <p class="help-block"></p>
        </div>
        <div class="col-xs-12 text-center input-panel" style="padding-top: 10px;">
            <textarea class="form-control" placeholder="付款备注" id="txtRemark" name="remark" <?php echo isset($key) ? 'style="display:none;"' : '';?>></textarea>
            <p class="help-block"></p>
        </div>
        <div class="col-xs-12 text-center" style="padding-top: 10px;">
            <a class="btn btn-danger" style="width: 100%;<?php echo isset($key) ? '' : 'display: none;';?>" id="btnCancelPay">撤消付款</a>
            <a class="btn btn-warning" style="width: 100%;<?php echo isset($key) ? 'display: none;' : '';?>" id="btnPay">付款</a>
        </div>
    </div>
</div>

<?php
$base_url = \Config::get('base_url');
$script = <<<js
    var _base_url = '{$base_url}'; 
js;

\Asset::js($script, [], 'before-script', true);

\Asset::js(['modules/trade/default/user/pay.js'], [], 'js-files', false);
?>
