拍品列表：<br>
<ul class="list-group">

</ul>

<?php foreach ($items as $item){ ?>
    <li class="list-group-item">
        <?= $item->id; ?>
        <?= $item->name; ?>
        <a href="/auction/lot/view/<?= $item->id; ?>">查看详情</a>
    </li>
<?php } ?>

<!-- Ajax加载其它拍品 -->
