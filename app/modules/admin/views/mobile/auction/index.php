<style type="text/css">
    body{
        background-color: #efefef;
    }
    .navbar{
        min-height: 42px !important;
    }
    .navbar .list-group .list-group-item{
        float: left;
        width: 20%;
        padding: 10px 0px;
        text-align: center;
        border-left: 0px;
        border-top: 0px;
    }
    .navbar .list-group .list-group-item:first-child, #lots .list-group-item:first-child{
        border-top-right-radius: 0px;
        border-top-left-radius: 0px;
    }
    .navbar .list-group .list-group-item:last-child, #lots .list-group-item:last-child{
        border-bottom-right-radius: 0px;
        border-bottom-left-radius: 0px;
        border-right: 0px;
    }
    .navbar .list-group .active{
        color: #d9534f;
        font-weight: 600;
        background-color: #fff !important;
        border-right: 1px solid #ddd !important;
        border-bottom: 1px solid #d9534f;
    }
    #lots .list-group-item dl{
        margin-top: 0px;
        margin-bottom: 0px;
    }
    #lots .list-group-item dl dt{
        color: #333;
    }
    #lots .list-group-item dl dd{
        font-size: 10pt;
        color: #aaa;
    }
</style>

<div class="navbar navbar-default navbar-fixed-top">
    <div class="list-group">
        <div class="list-group-item active">
            竞拍中
        </div>
        <div class="list-group-item">
            已截拍
        </div>
        <div class="list-group-item">
            已流拍
        </div>
        <div class="list-group-item">
            已失效
        </div>
        <div class="list-group-item">
            草稿箱
        </div>
    </div>
</div>

<div style="height: 45px;"></div>

<div class="container-fluid">

    <ul class="list-group" id="lots">
        <?php if(isset($items) && $items){ ?>
            <?php foreach($items as $item){ ?>
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-xs-4" style="padding-right: 0px;">
                            <img src="<?= $item->thumbnail->url; ?>" alt="<?= $item->name; ?>" style="width: 100%;">
                        </div>
                        <div class="col-xs-8">
                            <dl>
                                <dt><?= $item->name; ?></dt>
                                <dd>起拍价格：<?= $item->begin_price; ?></dd>
                                <dd>加价幅度：<?= $item->place_bid_range; ?></dd>
                                <dd>创建时间：<?= date('m月d日 h:i');?></dd>
                            </dl>
                        </div>
                        <div class="col-xs-12 text-right" style="padding-top: 40px">
                            <hr style="width: 100%; margin-top: 50px; margin-bottom: 5px">
                            <a class="btn btn-sm btn-<?= $item->status == 'active' ? 'danger' : 'success'; ?>"> 上架 </a>
                            <a class="btn btn-sm btn-primary"> <i class="fa fa-edit"></i> </a>
                            <a class="btn btn-sm btn-danger"> <i class="fa fa-trash-o"></i> </a>
                        </div>
                    </div>
                </li>
            <?php } ?>
        <?php }else{ ?>
            <li class="list-group-item">
                <div class="row">
                    <div class="col-xs-12 text-center" style="line-height: 20px; color: #aab0a6;">
                        <p><i class="fa fa-frown-o" style="font-size: 4em;"></i></p>
                        <p>没有这个状态的拍品~！</p>
                    </div>
                </div>
            </li>
        <?php } ?>

    </ul>

</div>

<?php
$script = <<<js
js;

\Asset::js($script, [], 'before-script', true);
\Asset::js(['tools.js', 'jquery-tmpl/jquery.tmpl.min.js', 'jquery-tmpl/jquery.tmplPlus.min.js', 'mobile/auction/index.js'], [], 'js-files', false);

?>