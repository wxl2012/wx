<style type="text/css">
    body{
        background-color: #efefef;
    }
    .navbar-blue{
        background-color: #337ab7;
        color: #fff;
    }
    .navbar-blue a{
        color: #fff;
    }
</style>
<nav class="navbar navbar-blue navbar-fixed-top">
    <div class="container">
        <div class="row">
            <div class="col-xs-3" style="line-height: 50px;">
                <a href="javascript:history.back(-1);"><i class="fa fa-angle-left" style="font-size: 1.5em;"></i></a>
            </div>
            <div class="col-xs-6 text-center" style="line-height: 50px;">
                我推荐的人
            </div>
            <div class="col-xs-3 text-right" style="line-height: 50px;">
            </div>
        </div>
    </div>
</nav>

<div style="height: 55px;"></div>

<div class="list-group">
    <div class="list-group-item">
        我的推荐人: 中国人
    </div>
</div>

<div class="list-group">
    <div class="list-group-item" style="font-weight: 600;">
        我推荐的人
    </div>
    <div class="list-group-item">
        <div class="row">
            <div class="col-xs-9">
                普通会员
            </div>
            <div class="col-xs-2 text-right" style="color: #aaa;">
                0
            </div>
            <div class="col-xs-1" style="color: #aaa;">
                <i class="fa fa-angle-right"></i>
            </div>
        </div>
    </div>
    <div class="list-group-item">
        <div class="row">
            <div class="col-xs-9">
                金钻会员
            </div>
            <div class="col-xs-2 text-right" style="color: #aaa;">
                0
            </div>
            <div class="col-xs-1" style="color: #aaa;">
                <i class="fa fa-angle-right"></i>
            </div>
        </div>
    </div>
    <div class="list-group-item">
        <div class="row">
            <div class="col-xs-9">
                铂钻会员
            </div>
            <div class="col-xs-2 text-right" style="color: #aaa;">
                0
            </div>
            <div class="col-xs-1" style="color: #aaa;">
                <i class="fa fa-angle-right"></i>
            </div>
        </div>
    </div>
</div>


<?php
$script = <<<js
js;

\Asset::js($script, [], 'before-script', true);
\Asset::js(['modules/ucenter/default/recommend/qrcode.js'], [], 'js-files', false);

?>