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
    input[type=text]{
        border: 0px;
        outline: none;
    }
</style>
<nav class="navbar navbar-blue navbar-fixed-top">
    <div class="container">
        <div class="row">
            <div class="col-xs-3" style="line-height: 50px;">
                <a href="javascript:history.back(-1);"><i class="fa fa-angle-left" style="font-size: 1.5em;"></i></a>
            </div>
            <div class="col-xs-6 text-center" style="line-height: 50px;">
                今日财报
            </div>
            <div class="col-xs-3 text-right" style="line-height: 50px;">
            </div>
        </div>
    </div>
</nav>

<div class="list-group" style="margin-top: 55px; margin-bottom: 5px;">
    <div class="list-group-item">
        <div class="row" style="background-color: #fff; line-height: 40px;">
            <div class="col-xs-3" style="padding-right: 0px;">
                今日营收
            </div>
            <div class="col-xs-9">
                0
            </div>
        </div>
    </div>
    <div class="list-group-item">
        <div class="row" style="background-color: #fff; line-height: 40px;">
            <div class="col-xs-3" style="padding-right: 0px;">
                今日返还
            </div>
            <div class="col-xs-9">
                0
            </div>
        </div>
    </div>
</div>

<div class="list-group">
    <div class="list-group-item">
        <div class="row" style="background-color: #fff; line-height: 40px;">
            <div class="col-xs-3" style="padding-right: 0px;">
                昨日营收
            </div>
            <div class="col-xs-9">
                0
            </div>
        </div>
    </div>
    <div class="list-group-item">
        <div class="row" style="background-color: #fff; line-height: 40px;">
            <div class="col-xs-3" style="padding-right: 0px;">
                昨日返还
            </div>
            <div class="col-xs-9">
                0
            </div>
        </div>
    </div>
</div>

<div class="container">

    <div class="row">
        <div class="col-xs-12">
            <div id="canvasDiv"></div>
        </div>
    </div>
</div>
<?php
$script = <<<js
    var _balance = 0;
    var _account_id = 0;
js;

\Asset::js($script, [], 'before-script', true);

\Asset::js(['ichartjs/ichart.1.2.1.min.js', 'modules/web/default/dashboard_day.js'], [], 'js-files', false);
?>