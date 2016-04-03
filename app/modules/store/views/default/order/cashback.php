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
                未结算的返现订单
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
            <?php foreach ($items as $order) { ?>
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
            <?php } ?>
        </tbody>

        <tfoot>
            <tr>
                <th colspan="4" class="text-center">
                    <select class="form-control" style="width: 80px; display: inline;">
                        <option value="1">1/5</option>
                        <option value="2">2/5</option>
                        <option value="3">3/5</option>
                        <option value="4">4/5</option>
                        <option value="5">5/5</option>
                    </select>
                </th>
            </tr>
        </tfoot>
    </table>

</div>