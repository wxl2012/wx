<style type="text/css">
    .pr3{
        padding-right: 3px;
    }
    .pl3{
        padding-left: 3px;
    }
    .pl3 dl{
        margin-top: 0px;
        margin-bottom: 0px;
    }
</style>
<div class="container-fluid" style="margin-bottom: 70px;">
    <div class="list-group" id="dishItems">
    </div>

    <div class="row">
        <div class="col-xs-12 text-center">
            <a href="javascript:;" id="btnMore">加载中...</a>
        </div>
    </div>
</div>

<script type="text/x-jquery-tmpl" id="dishItem">
    <div class="list-group-item" data-id="${id}">
        <div class="row">
            <div class="col-xs-5 pr3">
                <img style="width: 100%;" src="${goods.thumbnail}" alt="" />
            </div>
            <div class="col-xs-7 pl3">
                <dl>
                    <dt>${goods.name}</dt>
                    <dd>${goods.title}</dd>
                    <dd>￥ ${goods.sale_price}元</dd>
                </dl>
            </div>
        </div>
    </div>
    <div class="list-group-item text-right" data-id="${id}">
        <div class="row">
            <div class="col-xs-3">
            </div>
            <div class="col-xs-3">
            </div>
            <div class="col-xs-6">
                <div class="input-group">
                    <span class="input-group-addon" role="minus">-</span>
                    <input type="text" class="form-control text-center" value="0" role="number">
                    <span class="input-group-addon" role="plus">+</span>
                </div>
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
\Asset::js(['jquery-tmpl/jquery.tmpl.min.js', 'jquery-tmpl/jquery.tmplPlus.min.js', 'modules/restaurant/default/dish/index.js'], [], 'js-files', false);
?>