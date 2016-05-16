<style type="text/css">
    .navbar-fixed-bottom{
        padding-top: 5px;
    }
    .navbar-fixed-bottom .col-xs-3 i{
        font-size: 15pt;
    }
    .navbar-fixed-bottom .col-xs-3 p{
        margin-bottom: 0px;
    }
</style>
<nav class="navbar navbar-default navbar-fixed-bottom">
    <div class="container">
        <div class="row">
            <div class="col-xs-3 text-center menu-item" action="menu">
                <i class="fa fa-shopping-basket"></i>
                <p>菜单</p>
            </div>
            <div class="col-xs-3 text-center menu-item" action="cart">
                <i class="fa fa-shopping-cart"></i>
                <p>购物车</p>
                <span class="badge" style="position: absolute; right: 0px; top: -10px; background-color: #d9534f;">10</span>
            </div>
            <div class="col-xs-3 text-center menu-item" action="order">
                <i class="fa fa-file-text-o"></i>
                <p>订单</p>
            </div>
            <div class="col-xs-3 text-center menu-item" action="coupon">
                <i class="fa fa-money"></i>
                <p>优惠券</p>
            </div>
        </div>
    </div>
</nav>

<?php
$script = <<<js
js;

\Asset::js($script, [], 'before-script', true);
\Asset::js(['modules/restaurant/default/public/footer.js'], [], 'js-files', false);
?>