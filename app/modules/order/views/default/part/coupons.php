<?php
$seller = \Session::get('seller', false);
?>
<style type="text/css">
    #coupons .list-group-item{
        padding-top: 2px;
        padding-bottom: 2px;
    }
    #coupons .col-xs-10 p{
        margin-bottom: 0px;
    }
</style>
<div class="container-fluid">
    <?php if(isset($seller->open_coupon) && $seller->open_coupon){ ?>
    <p>
        可用优惠券
    </p>
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
    <p>
        优惠码
    </p>
    <ul class="list-group">
        <li class="list-group-item">
            <div class="row">
                <div class="col-xs-4" style="padding-right: 0px;">
                    <input type="text" class="form-control" name="no" value="" placeholder="优惠码"/>
                </div>
                <div class="col-xs-4" style="padding-left: 2px; padding-right: 0px;">
                    <input type="text" class="form-control" name="pwd" value="" placeholder="验证码"/>
                </div>
                <div class="col-xs-4">
                    <a class="btn btn-info" style="width: 100%;">验证</a>
                </div>
            </div>
        </li>
    </ul>
    <?php } ?>

    <?php if(isset($seller->open_member_score) && $seller->open_member_score) { ?>
        <?php if(\Auth::check() && isset($member) && $member->score > 0){ ?>
        <p>
            可用积分
            <span style="color: #aaa;">100积分=1元</span>
        </p>
        <ul class="list-group">
            <li class="list-group-item">
                <div class="row">
                    <div class="col-xs-12">
                        <input type="text" class="form-control" name="coupon_id" value="" placeholder="可用积分:10积分"/>
                    </div>
                </div>
            </li>
        </ul>
        <?php } ?>
    <?php } ?>

    <?php if(isset($seller->open_gift_money) && $seller->open_gift_money) { ?>
        <?php if(\Auth::check() && isset($member) && $member->gift_money > 0){ ?>
            <p>
                可用红包金额
            </p>
            <ul class="list-group">
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-xs-12">
                            <input type="text" class="form-control" name="gift_fee" value="" placeholder="可用金额:10"/>
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