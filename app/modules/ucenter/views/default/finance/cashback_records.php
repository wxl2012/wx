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
    .list-group-item p{
        margin-bottom: 0px;
    }
    #items{
        margin-bottom: 5px;
    }
    #items .list-group-item:first-child{
        border-top-left-radius: 0px;
        border-top-right-radius: 0px;
    }
    #items .list-group-item:last-child{
        border-bottom-left-radius: 0px;
        border-bottom-right-radius: 0px;
    }
    #btnMore{
        color: #aaa;
    }
</style>

<div class="container" style="margin-top: 5px; padding: 0px;">
    <ul class="list-group" id="items">
        <?php if(isset($items) && $items){ ?>
            <?php foreach ($items as $item) { ?>
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-xs-2" style="padding-right: 0px;">
                            <p><?php echo \handler\common\Date::getWeek($item->created_at); ?></p>
                            <p><?php echo date('m-d', $item->created_at);?></p>
                        </div>
                        <div class="col-xs-2">
                            <?php if($item->bank->category == 'ALIPAY'){ ?>
                                <img src="/assets/img/alipay.jpg" alt="" style="width: 100%;"/>
                            <?php } else if($item->bank->category == 'WXPAY'){ ?>
                                <img src="/assets/img/wxpay.png" alt="" style="width: 100%;"/>
                            <?php } else if($item->bank->category == 'BANK'){ ?>
                                <div class="img-circle text-center" style="background-color: #f0ad4e; line-height: 30px; width: 30px; height: 30px;">
                                    <i class="fa fa-credit-card" style="color: #fff; font-size: 1.2em;"></i>
                                </div>
                            <?php } ?>

                        </div>
                        <div class="col-xs-8">
                            <p><?php echo $item->money; ?></p>
                            <p>提现至<?php echo $item->bank->name; ?>(<?php echo \handler\common\Account::hidePart($item->account); ?>)</p>
                        </div>
                    </div>
                </li>
            <?php } ?>
        <?php }else{ ?>

        <?php } ?>
    </ul>
    <div class="text-center" style="line-height: 30px;">
        <a id="btnMore">已经是最后一页了</a>
    </div>
</div>

<?php
$script = <<<js
js;

\Asset::js($script, [], 'before-script', true);

\Asset::js(['valid.js', 'modules/ucenter/default/finance/cashback_records.js'], [], 'js-files', false);
?>