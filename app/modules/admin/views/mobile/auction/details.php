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
        结束时间：
        <?php if($item->end_at){ ?>
            <?= date('Y-m-d H:i:s', $item->end_at); ?>
        <?php } else { ?>
            <a class="btn btn-sm btn-danger" id="btnEnd">点击结束活动</a>
        <?php }?>

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

<?php
$script = <<<js
    var _id = {$item->id};
    var _max_price = {$item->t_he_last_hid};
    var _range = {$item->place_bid_range};
js;

\Asset::js($script, [], 'before-script', true);
\Asset::js(['tools.js', 'mobile/auction/details.js'], [], 'js-files', false);

?>