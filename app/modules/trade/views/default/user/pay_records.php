<style type="text/css">
    .list-group-item{
        font-size: 13px;
        margin-bottom: 10px;;
    }
    .tit{
        background-color: #fff;
        line-height: 50px;
        border-right: 1px solid #aaa;
    }
    .tit a{
        font-size: 13px;
        color: #333;
    }
    .tit .active{
        color: #d9534f;
    }
    .fc{
        color: #333;
    }
</style>
<?php
$params = \Input::get('order_type', false) ? '?order_type=' . \Input::get('order_type') : '';
?>
<nav class="navbar navbar-default navbar-fixed-top">
    <!-- We use the fluid option here to avoid overriding the fixed width of a normal container within the narrow content columns. -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-3 text-center tit">
                <a href="/trade/user/pay_records<?php echo $params;?>"<?php echo \Input::get('status', true) === true ? ' class="active"' : '';?>>全部</a>
            </div>
            <div class="col-xs-3 text-center tit">
                <a href="/trade/user/pay_records<?php echo $params ? $params . '&' : '?';?>status=WAIT_PAYMENT"<?php echo \Input::get('status', false) == 'WAIT_PAYMENT' ? ' class="active"' : '';?>>待付款</a>
            </div>
            <div class="col-xs-3 text-center tit">
                <a href="/trade/user/pay_records<?php echo $params ? $params . '&' : '?';?>status=PAYMENT_SUCCESS"<?php echo \Input::get('status', false) == 'PAYMENT_SUCCESS' ? ' class="active"' : '';?>>已付款</a>
            </div>
            <div class="col-xs-3 text-center tit" style="border-right: 0px;">
                <a href="/trade/user/pay_records<?php echo $params ? $params . '&' : '?';?>status=CLOSE"<?php echo \Input::get('status', false) == 'FINISH' ? ' class="active"' : '';?>>已关闭</a>
            </div>
        </div>
    </div>
</nav>
<ul class="list-group" style="padding: 10px 5px; margin-top: 55px;">
    <?php if(! isset($items) || ! $items){ ?>
        <li class="list-group-item text-center">
            未找到相关数据!
        </li>
    <?php }else{ ?>
        <?php foreach ($items as $item) { ?>
            <li class="list-group-item" data-id="<?php echo $item->id;?>">
                <div class="row" style="border-bottom: 1px solid #aaa; line-height: 30px;">
                    <div class="col-xs-9 fc">
                        订单号：<?php echo $item->order_no; ?>
                    </div>
                    <div class="col-xs-3 text-right">
                        <label class="label label-<?php echo \Model_Order::$_maps['labels'][$item->order_status]; ?>"><?php echo \Model_Order::$_maps['status'][$item->order_status];?></label>
                    </div>
                </div>

                <?php foreach( $item->details as $detail){ ?>
                    <div class="row" style="padding-top: 5px; color: #aaa;">
                        <div class="col-xs-4" style="padding-right: 0px; padding-top: 10px;">
                            <?php
                            $thumbnail = '/assets/web/images/01.jpg';
                            $title = '';
                            if(in_array($item->order_type, ['SELL', 'GROUPBUY'])){
                                $thumbnail = $detail->goods->thumbnail;
                                $title = $detail->goods->title;
                            }else if($item->order_type == 'MARKET'){
                                $thumbnail = $detail->market->thumbnail;
                                $title =  $detail->market->title ?  $detail->market->title : $detail->goods->title;
                            }else if($item->order_type == 'RESERVE'){
                                $title = "{$detail->table->name}({$detail->seat->name})";
                            }
                            $title = \Str::truncate($title, 25, '...');
                            ?>
                            <img src="<?php echo$thumbnail;?>" alt="" style="width: 100%;">
                        </div>
                        <div class="col-xs-8" style="border-bottom: 1px solid #efefef;">
                            <p style=" padding-top: 10px;"><?php echo $title;?></p>
                            <?php if($item->order_type == 'MARKET'){ ?>
                                <p style=" height: 50px; overflow: auto;">夺宝号码：<?php echo $detail->sn;?></p>
                            <?php } else { ?>
                                <div class="clear">
                                    <p class="pull-left">
                                        单价：￥<?php echo $detail->price;?>
                                    </p>
                                    <p class="pull-right">
                                        数量：￥<?php echo $detail->num;?>
                                    </p>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>


                <div class="row" style="padding-top: 10px;">
                    <div class="col-xs-6 fc" style="line-height: 35px; padding-right: 0px;">
                        <?php echo $item->order_type == 'RESERVE' ? '观演:' : '下单:'; ?>
                        <?php echo $item->order_type == 'RESERVE' ? date('Y-m-d', $item->arrived_at) : date('Y-m-d', $item->created_at);?>
                    </div>
                    <div class="col-xs-6 text-right fc" style="line-height: 35px; padding-left: 2px;">
                        <span>总金额：￥<?php echo $item->money;?></span>
                    </div>
                </div>

                <?php if(in_array($item->order_status, ['WAIT_PAYMENT', 'SYSTEM_STOP', 'PAYMENT_SUCCESS', 'SECTION_FINISH'])){ ?>
                    <div class="row" style="border-top: 1px solid #aaa; line-height: 30px;">
                        <div class="col-xs-12 text-right" style="line-height: 35px;">
                            <?php if($item->order_status == "WAIT_PAYMENT"){ ?>
                                <a href="/services/gateway/pay/<?php echo strtolower($item->payment_type)?>?order_id=<?php echo $item->id;?>" class="btn btn-sm btn-warning">去支付</a>
                                <a class="btn btn-sm btn-danger" role="del"><i class="fa fa-trash-o"></i> 删除</a>
                            <?php }else if(in_array($item->order_status, ['PAYMENT_SUCCESS', 'SECTION_FINISH'])){ ?>
                                <a href="/ucenter/order/delivery/<?php echo $item->id; ?>" class="btn btn-sm btn-warning">使用</a>
                            <?php }else if($item->order_status == "SYSTEM_STOP"){ ?>
                                <a class="btn btn-sm btn-danger" role="del"><i class="fa fa-trash-o"></i> 删除</a>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </li>
        <?php } ?>
    <?php } ?>
</ul>

<script type="text/javascript">
    $(function(){
        $('a[role=del]').click(function(){
            $.get('/ucenter/order/delete/' + $(this).parents('li').attr('data-id'),
                function(data){
                    if(data.status == 'err'){
                        alert(data.msg);
                        return;
                    }
                    window.location.reload();
                }, 'json');
        });
    });
</script>