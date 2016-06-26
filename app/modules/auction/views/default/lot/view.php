<style type="text/css">
    .input-panel{
        position: fixed;
        bottom: 0px;
        width: 100%;
        background-color: #efefef;
    }
    .help-block{
        color: #d9534f;
    }
</style>
<ul class="list-group">
    <li class="list-group-item">
        拍品编号：<?= $item->id; ?>
    </li>
    <li class="list-group-item">
        拍品名称：<?= $item->name; ?>
    </li>
    <li class="list-group-item">
        起拍价格：<?= $item->begin_price; ?>
    </li>
    <li class="list-group-item">
        加价幅度：<?= $item->place_bid_range; ?>
    </li>
    <li class="list-group-item">
        保证金：<?= $item->recognizance; ?>
    </li>
    <li class="list-group-item">
        开拍时间：<?= $item->begin_at ? date('Y-m-d H:i:s', $item->begin_at) : ''; ?>
    </li>
    <li class="list-group-item">
        结束时间：<?= $item->end_at ? date('Y-m-d H:i:s', $item->end_at) : ''; ?>
    </li>

    <li class="list-group-item text-center">
        <a class="btn btn-primary" id="btnBid">我要出价</a>
    </li>
</ul>


<ul class="list-group">
    <?php foreach ($item->records as $record){ ?>
        <li class="list-group-item">
            出价人：<?= "{$record->buyer->first_name}{$record->buyer->last_name}"; ?><br>
            ￥ <?= $record->bid; ?>
        </li>
    <?php } ?>
</ul>

<div class="input-panel" style="display: none;">
    <div class="container" style="font-size: 10pt;">
        <div class="row">
            <div class="col-xs-8" style="padding: 10px 15px;">
                领先价格：<span id="maxPrice"><?= $item->t_he_last_hid; ?></span>
            </div>
            <div class="col-xs-4 text-right" style="padding-top: 5px;">
                <a id="btnClose" href="javascript:;">
                    <i class="fa fa-close" style="font-size: 2em; color: #aaa;"></i>
                </a>
            </div>
        </div>
        <div class="row" id="help-panel" style="display: none;">
            <div class="col-xs-12">
                <p class="help-block">有错误</p>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <input type="number" id="price" value="" placeholder="我要出价" class="form-control" />
            </div>
            <div class="col-xs-12 text-center" style="padding: 10px 15px;">
                <a class="btn btn-success" id="btnSubmit" style="width: 100%;">出价</a>
            </div>
            <div class="col-xs-12 text-right" style="color: #aaa;">
                出价即表示同意<a>《竞拍服务协议》</a>
            </div>
        </div>
    </div>
</div>
<?php
$script = <<<js
    var _id = {$item->id};
    var _max_price = {$item->t_he_last_hid};
    var _range = {$item->place_bid_range};
js;

\Asset::js($script, [], 'before-script', true);
\Asset::js(['tools.js', 'modules/auction/view.js'], [], 'js-files', false);

?>