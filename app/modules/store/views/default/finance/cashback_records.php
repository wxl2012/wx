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
    .list-group-item p{
        margin-bottom: 0px;
    }
    #items{
        margin-bottom: 5px;
    }
    #items .list-group-item:first-child{
        border-top-left-radius: 0px;
        border-top-right-radius: 0px;
    }
    #items .list-group-item:last-child{
        border-bottom-left-radius: 0px;
        border-bottom-right-radius: 0px;
    }
    #btnMore{
        color: #aaa;
    }
</style>
<nav class="navbar navbar-blue navbar-fixed-top">
    <div class="container">
        <div class="row">
            <div class="col-xs-3" style="line-height: 50px;">
                <a href="javascript:history.back(-1);"><i class="fa fa-angle-left" style="font-size: 1.5em;"></i></a>
            </div>
            <div class="col-xs-6 text-center" style="line-height: 50px;">
                提现记录
            </div>
            <div class="col-xs-3 text-right" style="line-height: 50px;">
                <!--<a href="javascript:;">筛选</a>-->
            </div>
        </div>
    </div>
</nav>

<div class="container" style="margin-top: 55px; padding: 0px;">
    <ul class="list-group" id="items">
        <?php for($i = 0; $i < 10; $i ++) { ?>
            <li class="list-group-item">
                <div class="row">
                    <div class="col-xs-2" style="padding-right: 0px;">
                        <p>周一</p>
                        <p>01-22</p>
                    </div>
                    <div class="col-xs-2">
                        <?php if($i == 3){ ?>
                            <img src="/assets/img/alipay.jpg" alt="" style="width: 100%;"/>
                        <?php } else if($i == 5){ ?>
                            <img src="/assets/img/wxpay.png" alt="" style="width: 100%;"/>
                        <?php }else{ ?>
                            <div class="img-circle text-center" style="background-color: #f0ad4e; line-height: 30px; width: 30px; height: 30px;">
                                <i class="fa fa-credit-card" style="color: #fff; font-size: 1.2em;"></i>
                            </div>
                        <?php } ?>

                    </div>
                    <div class="col-xs-8">
                        <p>- 10.00</p>
                        <p>提现至中国银行(1234)</p>
                    </div>
                </div>
            </li>
        <?php } ?>
    </ul>
    <div class="text-center" style="line-height: 30px;">
        <a id="btnMore">已经是最后一页了</a>
    </div>
</div>
