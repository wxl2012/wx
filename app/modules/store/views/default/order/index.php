<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="row">
            <div class="col-xs-3" style="line-height: 50px;">
                <a href="javascript:history.back(-1);"><i class="fa fa-angle-left" style="font-size: 1.5em;"></i></a>
            </div>
            <div class="col-xs-6 text-center" style="line-height: 50px;">
                店铺订单
            </div>
            <div class="col-xs-3">
            </div>
        </div>
    </div>
</nav>

<div class="container" style="margin-top: 60px; padding-left: 5px;padding-right: 5px;">
    <div class="list-group">
        <?php foreach ($items as $item){ ?>
            <div class="list-group-item">
                <div class="row">
                    <div class="col-xs-7" style="padding-left: 5px; padding-right: 0px;">
                        订单号:<?php echo $item->order_no;?>
                    </div>
                    <div class="col-xs-5 text-right" style="padding-left:0px; padding-right: 5px;">
                        <?php echo date('Y-m-d H:i'); ?>
                    </div>
                </div>
            </div>
            <?php foreach ($item->details as $detail) { ?>
                <div class="list-group-item">
                    <div class="row">
                        <div class="col-xs-4" style="padding-left: 2px; padding-right: 0px;">
                            <img src="<?php echo $detail->goods->thumbnail; ?>" alt="<?php echo $detail->goods->title; ?>" style="width: 100%; height: 100%;"/>
                        </div>
                        <div class="col-xs-8">
                            <dl style="margin-top: 0px; margin-bottom: 0px;">
                                <dt><?php echo \Str::truncate($detail->goods->title, 25, '...'); ?></dt>
                                <dd>数量: <?php echo $detail->num; ?> <span style="padding-left: 5px">单价: <?php echo $detail->price; ?></span></dd>
                            </dl>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="list-group-item" style="margin-bottom: 10px; padding-top: 5px; padding-bottom: 5px;">
                <div class="row">
                    <div class="col-xs-3" style="padding-left: 5px; padding-right: 0px; line-height: 28px;">
                        <label class="label label-danger">待支付</label>
                    </div>
                    <div class="col-xs-9 text-right" style="padding-left:0px; padding-right: 5px;">
                        <a class="btn btn-sm btn-danger">关闭订单</a>
                        <a class="btn btn-sm btn-danger">删除订单</a>
                        <a class="btn btn-sm btn-warning">去支付</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

</div>