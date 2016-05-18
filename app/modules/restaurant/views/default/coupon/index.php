<style type="text/css">
    dl{
        margin: 10px 0px;
    }
    dt{
        font-size: 12pt;
    }
    dd{
        font-size: 9pt;
    }
    .coupon .money{
        font-size: 18pt;
        border-radius: 10px;
        background-color: #d9534f;
        padding-left: 5px;
        padding-right: 5px;
        text-align: center;
        min-height: 64px;
    }
    .coupon .summary{
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
        background-color: #d9534f;
        border-left: 1px dashed #fff;
        min-height: 64px;
    }
    .coupon .button{
        padding-left: 5px;
        padding-right: 5px;
        background-color: #d9534f;
        border-left: 1px dashed #fff;
        line-height: 32px;
        font-size: 30pt;
        line-height: 64px;
    }
    /* 已过期,或已使用 */
    .gray .money, .gray .summary, .gray .button{
        background-color: lightgray;
    }
    /* 可用 */
    .green .money, .green .summary, .green .button{
        background-color: #5cb85c;
    }
    /* 即将过期 */
    .warning .money, .warning .summary, .warning .button{
        background-color: #f0ad4e;
    }
    #btnMore{
        text-decoration: none;
        color: #aaa;
    }
</style>

<div class="container" style="margin-bottom: 55px; padding-top: 5px;">
    <?php for($i = 0; $i < 10; $i ++){ ?>
        <div class="row coupon <?php echo $i % 2 == 0 ? $i % 4 == 0 ? 'warning' : 'gray' : 'green'; ?>" style="margin-bottom: 2px; line-height: 64px; color: #fff;">
            <div class="col-xs-3 money">
                100元
            </div>
            <div class="col-xs-6 summary">
                <dl>
                    <dt>优惠券</dt>
                    <dd>满100元使用</dd>
                </dl>
            </div>
            <div class="col-xs-3 button text-center">
                <!--点 &nbsp;&nbsp;&nbsp;击<br>使 &nbsp;&nbsp;&nbsp;&nbsp;用-->
                券
            </div>
        </div>
    <?php } ?>
    <div class="text-center" style="padding: 10px 0px;">
        <a href="javascript:;" id="btnMore">已经没有下一页了</a>
    </div>
</div>

<?php
$script = <<<js
    var _dish_list = [];
js;

\Asset::js($script, [], 'before-script', true);
\Asset::js(['modules/restaurant/default/coupon/index.js'], [], 'js-files', false);
?>