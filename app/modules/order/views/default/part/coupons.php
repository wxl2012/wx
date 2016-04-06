<?php
$seller = \Session::get('seller', false);
?>
<style type="text/css">
    #coupons .col-xs-10 p{
        margin-bottom: 0px;
    }
</style>
<div class="container-fluid">
    <?php if(isset($seller->open_coupon) && $seller->open_coupon){ ?>
    <div class="title">
        <span class="line_orange"></span>
        可用优惠券
    </div>
    <ul class="list-group" id="coupons">
        <li class="list-group-item">
            <div class="row">
                <div class="col-xs-2" style="padding-right: 0px">
                    <input type="checkbox" name="coupon_id" value=""/>
                </div>
                <div class="col-xs-8" style="padding-left: 0px">
                    五一优惠券
                </div>
                <div class="col-xs-2" style="padding-left: 0px">
                    $1000
                </div>
            </div>
        </li>
        <li class="list-group-item">
            <div class="row">
                <div class="col-xs-2" style="padding-right: 0px">
                    <input type="checkbox" name="coupon_id" value=""/>
                </div>
                <div class="col-xs-8" style="padding-left: 0px">
                    五一优惠券
                </div>
                <div class="col-xs-2" style="padding-left: 0px">
                    $1000
                </div>
            </div>
        </li>
    </ul>
    <?php } ?>

    <?php if(isset($seller->open_coupon_sn) && $seller->open_coupon_sn){ ?>
    <div class="title">
        <span class="line_orange"></span>
        优惠码
    </div>
    <ul class="list-group" id="couponSn">

        <li class="list-group-item">
            <div class="row">
                <div class="col-xs-4" style="padding-right: 0px;">
                    <input type="text" class="form-control" name="no" value="" placeholder="优惠码"/>
                </div>
                <div class="col-xs-4" style="padding-left: 2px; padding-right: 0px;">
                    <input type="text" class="form-control" name="pwd" value="" placeholder="验证码"/>
                </div>
                <div class="col-xs-4">
                    <a class="btn btn-info" style="width: 100%;" id="btnCheck">验证</a>
                </div>
            </div>
        </li>
    </ul>
    <?php } ?>

    <?php if(isset($seller->open_member_score) && $seller->open_member_score) { ?>
        <?php if(\Auth::check() && isset($member) && $member->score > 0){ ?>
        <div class="title">
            <span class="line_orange"></span>
            可用积分
            <!--<span style="color: #aaa;">100积分=1元</span>-->
        </div>
        <ul class="list-group">
            <li class="list-group-item">
                <div class="row">
                    <div class="col-xs-12">
                        <input type="text" class="form-control" id="score" name="score" value="" placeholder="可用积分:<?php echo $member->score; ?>积分"/>
                    </div>
                </div>
            </li>
        </ul>
        <?php } ?>
    <?php } ?>

    <?php if(isset($seller->open_gift_money) && $seller->open_gift_money) { ?>
        <?php if(\Auth::check() && isset($member) && $member->gift_money > 0){ ?>
            <div class="title">
                <span class="line_orange"></span>
                可用红包金额
            </div>
            <ul class="list-group">
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-xs-12">
                            <input type="text" class="form-control" id="gift_fee" name="gift_fee" value="" placeholder="可用金额:<?php echo $member->gift_money; ?>元"/>
                        </div>
                    </div>
                </li>
            </ul>
        <?php } ?>
    <?php } ?>

</div>


<script type="text/x-jquery-tmpl" id="couponItem">
    <li class="list-group-item">
        <div class="row">
            <div class="col-xs-2" style="padding-right: 0px">
                <input type="checkbox" name="coupon_id" value="${id}"/>
            </div>
            <div class="col-xs-8" style="padding-left: 0px">${coupon.name}</div>
            <div class="col-xs-2" style="padding-left: 0px">${coupon.money}${unit}</div>
        </div>
    </li>
</script>

<script type="text/x-jquery-tmpl" id="couponSnItem">
    <li class="list-group-item">
        <div class="row">
            <div class="col-xs-2" style="padding-right: 0px;">
                <input type="checkbox" name="coupon_id" value="${id}" max-num="${coupon.max_num}" data-type="${coupon.type}" data-value="${coupon.money}"/>
            </div>
            <div class="col-xs-6" style="padding-left: 2px; padding-right: 0px;">
                优惠码:${sn}
            </div>
            <div class="col-xs-4 text-right" style="color: red;">
            {{if coupon.type == 'AMOUNT' }}
                ${coupon.money}元
            {{else coupon.type == 'DISCOUNT'}}
                ${coupon.money}折
            {{/if }}
            </div>
        </div>
    </li>
</script>

<?php
    \Asset::js('order/default/part/coupons.js', [], 'js-files', false);
?>