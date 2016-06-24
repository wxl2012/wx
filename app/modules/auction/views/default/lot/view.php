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
        开拍时间：<?= date('Y-m-d H:i:s', $item->begin_at); ?>
    </li>
    <li class="list-group-item">
        结束时间：<?= date('Y-m-d H:i:s', $item->end_at); ?>
    </li>

    <li class="list-group-item text-center">
        <a class="btn btn-primary">我要出价</a>
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
