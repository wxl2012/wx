<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="row">
            <div class="col-xs-3" style="line-height: 50px;">
                <a href="javascript:history.back(-1);"><i class="fa fa-angle-left" style="font-size: 1.5em;"></i></a>
            </div>
            <div class="col-xs-6 text-center" style="line-height: 50px;">
                订单详情
            </div>
            <div class="col-xs-3">
            </div>
        </div>
    </div>
</nav>

<div class="container" style="margin-top: 60px; padding-left: 5px;padding-right: 5px;">
    <div class="list-group">
        <div class="list-group-item">
            订&nbsp;&nbsp;单&nbsp;&nbsp;号: <?php echo time();?>
        </div>
        <div class="list-group-item">
            订单状态: <label class="label label-success">已付款</label>
        </div>
        <div class="list-group-item">
            支付方式: 支付宝
        </div>
        <div class="list-group-item">
            下单时间: <?php echo date('Y-m-d H:i:s'); ?>
        </div>
        <div class="list-group-item">
            付款时间: <?php echo date('Y-m-d H:i:s'); ?>
        </div>
        <div class="list-group-item">
            备注信息: 没有备注信息
        </div>
        <?php for($i = 0; $i < 2; $i ++){ ?>
            <div class="list-group-item">
                <div class="row">
                    <div class="col-xs-4" style="padding-left: 2px; padding-right: 0px;">
                        <img src="http://www.qh.xinhuanet.com/misc/2009-09/28/xin_1430906281757515084669.jpg" alt="" style="width: 100%; height: 100%;"/>
                    </div>
                    <div class="col-xs-8">
                        <dl style="margin-top: 0px; margin-bottom: 0px;">
                            <dt>商品标题商品标题商品标题商品标题商品标题</dt>
                            <dd>数量: 500 <span style="padding-left: 5px">单价: 123.00</span></dd>
                        </dl>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="list-group-item text-right" style="margin-bottom: 10px; padding-top: 5px; padding-bottom: 5px;">
            <a class="btn btn-sm btn-warning">去支付</a>
        </div>
    </div>

</div>