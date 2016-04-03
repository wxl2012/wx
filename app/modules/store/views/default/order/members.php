<style type="text/css">
    .table-bordered thead th{
        text-align: center;
    }
</style>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="row">
            <div class="col-xs-3" style="line-height: 50px;">
                <a href="javascript:history.back(-1);"><i class="fa fa-angle-left" style="font-size: 1.5em;"></i></a>
            </div>
            <div class="col-xs-6 text-center" style="line-height: 50px;">
                会员返现明细
            </div>
            <div class="col-xs-3">
            </div>
        </div>
    </div>
</nav>

<div class="container" style="margin-top: 60px; padding-left: 5px;padding-right: 5px;">

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>订单号</th>
            <th>支付金额</th>
            <th>状态</th>
            <th>返现额</th>
        </tr>
        </thead>

        <tbody>
        <?php $depth = 0; ?>
        <?php foreach ($items as $member) { ?>
            <?php if($depth != $member->depth){ ?>
                <?php $depth = $member->depth;?>
                <tr class="active">
                    <td colspan="4">
                        <?php echo $depth?>级会员订单 (<?php echo count($member->member->orders); ?>单)
                    </td>
                </tr>
            <?php } ?>
            <?php if($member->member->orders){ ?>
                <?php foreach ($member->member->orders as $order) { ?>
                    <?php if($order->store_id == 0){ continue; }?>
                    <tr>
                        <td><?php echo $order->order_no;?></td>
                        <td><?php echo $order->original_fee; ?></td>
                        <td>
                            <?php
                            if($order->order_status == 'FINISH' && ! $order->cashback_status){
                                echo "待返现";
                            }else if($order->cashback_status){
                                echo "已返现";
                            }else{
                                echo \Model_Order::$_maps['status'][$order->order_status];
                            }
                            ?>
                        </td>
                        <td><?php echo $order->original_fee * 0.1 * 0.5;?></td>
                    </tr>
                <?php }?>
            <?php }else{ ?>
                <tr>
                    <td colspan="4" class="text-center" style="color: #aaa;">
                        无订单记录
                    </td>
                </tr>
            <?php } ?>

        <?php } ?>
        </tbody>

        <tfoot>
            <tr>
                <th colspan="4">
                    共计: 0单 0元
                </th>
            </tr>
        </tfoot>

    </table>

</div>