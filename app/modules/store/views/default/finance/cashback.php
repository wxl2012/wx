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
    .dashboard{
        padding-top: 10px;
        font-size: 1.5em;
        color: #5bc0de;
        background-color: #fff;
        padding-bottom: 15px;
    }
    #money{
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
                申请提现
            </div>
            <div class="col-xs-3 text-right" style="line-height: 50px;">
                <a href="/store/finance/cashback_records">明细</a>
            </div>
        </div>
    </div>
</nav>

<div class="container" style="margin-top: 55px;">
    <div class="row">
        <div class="col-xs-12 dashboard text-center">
            <p>当前可用金额(元)</p>
            <p>0.00</p>
        </div>
        <div class="col-xs-12 text-center" style="padding: 10px 0px; font-size: 9pt; color: #aaa;">
            单次提现不低于100,不超过50000,一天最多提现3次
        </div>
    </div>
    <div class="row" style="background-color: #fff; line-height: 40px;">
        <div class="col-xs-3" style="padding-right: 0px;">
            提现金额
        </div>
        <div class="col-xs-9">
            <input type="text" value="" placeholder="请输入提现金额" id="money">
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 text-center" style="padding: 25px 5px;">
            <a class="btn btn-primary" style="width: 100%;">提现</a>
            <p style="padding: 10px 0px;">
                <?php if(true){ ?>
                    请先绑定银行卡或者支付宝 <a href="javascript:;">绑定</a>
                <?php }else{ ?>
                    使用中国银行(9081)收款 <a href="javascript:;">更换</a>
                <?php } ?>
            </p>
        </div>
    </div>
</div>
