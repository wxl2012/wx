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
                    确认收款
                </div>
                <div class="col-xs-2">
                </div>
            </div>
        </div>
    </nav>
<?php } ?>

<div class="container" style="padding-top: 15px;">

    <?php
    $nickname = '';
    if($buyer->people->first_name && $buyer->people->last_name){
        $nickname = "{$buyer->people->first_name}{$buyer->people->last_name}";
    }else if($buyer->people->nickname){
        $nickname = $buyer->people->nickname;
    }else if($buyer->people->wechat){
        $nickname = $buyer->people->wechat->nickname;
    }
    ?>
    <ul class="list-group">
        <li class="list-group-item">
            <div class="row">
                <div class="col-xs-4">
                    付款人:
                </div>
                <div class="col-xs-8">
                    <?php echo $nickname;?>
                </div>
            </div>
        </li>
        <li class="list-group-item">
            <div class="row">
                <div class="col-xs-4">
                    付款金额:
                </div>
                <div class="col-xs-8">
                    <?php echo isset($order) ? $order['total_fee'] : '';?>
                </div>
            </div>
        </li>
        <li class="list-group-item">
            <div class="row">
                <div class="col-xs-4">
                    付款说明:
                </div>
                <div class="col-xs-8">
                    <?php echo isset($order) ? $order['remark'] : '';?>
                </div>
            </div>
        </li>
    </ul>
    <div class="row">
        <div class="col-xs-12 text-center" style="padding-top: 10px;">
            <a class="btn btn-success" style="width: 100%;"> <i class="fa fa-check"></i> 确认收款</a>
        </div>
        <div class="col-xs-12 text-center" style="padding-top: 10px;">
            <a class="btn btn-danger" style="width: 100%;"> <i class="fa fa-times"></i> 信息有误</a>
        </div>
    </div>
</div>


<?php
$script = <<<js
js;

\Asset::js($script, [], 'before-script', true);

\Asset::js(['modules/trade/default/seller/collection.js'], [], 'js-files', false);
?>
