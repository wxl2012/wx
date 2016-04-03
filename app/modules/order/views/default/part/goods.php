<?php
$seller = \Session::get('seller', false);
if( ! isset($seller->open_goods_details) || ! $seller->open_goods_details){
    return;
}
?>
<style type="text/css">
    #goodsItems .list-group-item{
        padding-top: 5px;
        padding-bottom: 5px;
    }
    #goodsItems .list-group-item{
        border-radius: 0px;
    }
</style>
<div class="container-fluid">
    <p>
        商品明细
    </p>
    <ul class="list-group" id="goodsItems">
        <div id="goodsFirst">
        </div>
        <div id="goodsBody">
            <li class="list-group-item text-center">
                <i class="fa fa-spinner fa-spin"></i> 数据加载中...
            </li>
        </div>
        <div id="goodsFooter">
            <li class="list-group-item text-right clearfix" id="btnGoodsMore" style="border-top-width: 0px">
                <span class="pull-left">共<em>0</em>件商品<em>0</em>元</span>
                <span class="pull-right" style="display: none;">查看更多</span>
            </li>
        </div>
    </ul>
</div>

<script type="text/x-jquery-tmpl" id="goodsItem">
    <li class="list-group-item" data-id="${id}">
        <div class="row">
            <div class="col-xs-4" style="padding-left:3px; padding-right: 0px">
                <img src="${goods.thumbnail}" alt="" style="width: 100%;"/>
            </div>
            <div class="col-xs-8">
                <p>${goods.name}</p>
                <p>数量:${num}<span style="padding-left: 10px;">价格:</span>${price}元 </p>
            </div>
        </div>
    </li>
</script>

<?php
$script = <<<js
    var _ids = [1, 2, 3];
js;

    \Asset::js($script, [], 'before-script', true);
    \Asset::js('order/default/part/goods.js', [], 'js-files', false);
?>