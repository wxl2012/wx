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
                我要推广
            </div>
            <div class="col-xs-3 text-right" style="line-height: 50px;">
            </div>
        </div>
    </div>
</nav>

<div class="container" style="margin-top: 55px;">
    <div class="row">
        <div class="col-xs-12">
            推广ID: <?php echo time(); ?>
        </div>
        <div class="col-xs-12 text-center">
            <img src="/common/image/qr?content=test">
        </div>
    </div>
</div>
