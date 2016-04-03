<?php echo render('default/part/address'); ?>
<?php echo render('default/part/goods'); ?>
<?php echo render('default/part/payments'); ?>
<?php echo render('default/part/coupons'); ?>

<style type="text/css">
    .navbar-white{
        background-color: #fff;
    }
</style>
<div class="container-fluid">
    <p>
        备注
    </p>
    <ul class="list-group">
        <li class="list-group-item">
            <textarea class="form-control" placeholder="订单备注信息"></textarea>
        </li>
    </ul>
</div>

Ajax创建订单<br>
微信支付时,本页调用支付页面<br>
支付宝支付时,跳转至支付宝支付页面并开始支付;显示右上角浏览器中打开<br>
<div style="height: 50px;"></div>
<nav class="navbar navbar-white navbar-fixed-bottom">
    <div class="container">
        <div class="row">
            <div class="col-xs-12" style="line-height: 50px;">
                <a class="btn btn-danger" style="width: 100%;" id="btnPay">立即支付</a>
            </div>
        </div>
    </div>
</nav>

<?php
$script = <<<js
    var _order_name = '';
    var _order_body = '';
    var _total_fee = 0;
    var _original_fee = 0;
    var _preferential_fee = 0;
    var _order_type = '';
js;

    \Asset::js($script, [], 'before-script', true);
    \Asset::js(['icheck/icheck.min.js', 'jquery-tmpl/jquery.tmpl.min.js', 'jquery-tmpl/jquery.tmplPlus.min.js', 'order/default/create.js'], [], 'js-files', false);

    \Asset::css(['icheck/skins/flat/orange.css', 'font-awesome/4.5.0/css/font-awesome.min.css'], [], 'css-files', false);
?>