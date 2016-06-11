<style type="text/css">
    #orderItems{
        color: #aaa;
    }
    .list-group-item:first-child{
        border-top-left-radius: 0px;
        border-top-right-radius: 0px;
    }
    .list-group-item:last-child{
        border-top-left-radius: 0px;
        border-top-right-radius: 0px;
    }
</style>
<div class="container-fluid" style="margin-bottom: 70px;">
    <div class="list-group" id="orderItems">
    </div>

    <div class="row">
        <div class="col-xs-12 text-center">
            <a href="javascript:;" id="btnMore">加载中...</a>
        </div>
    </div>
</div>

<script type="text/x-jquery-tmpl" id="orderItem">
    <div class="list-group-item">
        <div class="row">
            <div class="col-xs-12" style="padding-left: 5px; padding-right: 0px;">
                订&nbsp;&nbsp;单&nbsp;&nbsp;号: ${order_no}
            </div>
        </div>
    </div>
    <div class="list-group-item">
        <div class="row">
            <div class="col-xs-12" style="padding-left: 5px; padding-right: 0px;">
                下单时间: ${created_date}
            </div>
        </div>
    </div>
    {{each(i,detail) items}}
    <div class="list-group-item">
        <div class="row">
            <div class="col-xs-4" style="padding-left: 2px; padding-right: 0px;">
                <img src="${detail.goods.thumbnail}" alt="${detail.goods.title}" style="width: 100%; height: 100%;"/>
            </div>
            <div class="col-xs-8">
                <dl style="margin-top: 0px; margin-bottom: 0px;">
                    <dt>${detail.goods.name}</dt>
                    <dd>数量: ${detail.num} <span style="padding-left: 5px">单价: ${detail.price}</span></dd>
                </dl>
            </div>
        </div>
    </div>
    {{/each}}
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
</script>

<?php
$access_token = \Session::get('access_token', '');
$script = <<<js
    var _dish_list = [];
    var _access_token = '{$access_token}';
    var _pageIndex = 1;
    var _totalPage = 1;
js;

\Asset::js($script, [], 'before-script', true);
\Asset::js(['tools.js', 'jquery-tmpl/jquery.tmpl.min.js', 'jquery-tmpl/jquery.tmplPlus.min.js', 'modules/restaurant/default/order/index.js'], [], 'js-files', false);
?>