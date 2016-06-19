<style type="text/css">
    .input-group, .form-control, #btnSearch{
        height: 40px;
    }
    .form-control{
        font-size: 15pt;
    }
    #btnSearch{
        background-color: #3f3d3b;
    }
    #btnSearch i{
        color: #fff;
    }
    .list-group .list-group-item{
        background-color: transparent;
        border-top: 0px;
        border-left: 0px;
        border-right: 0px;
        text-align: left;
    }
    .list-group .list-group-item:first-child{
        border-top-left-radius: 0px;
        border-top-right-radius: 0px;
    }
    .list-group .list-group-item:first-child{
        border-bottom-left-radius: 0px;
        border-bottom-right-radius: 0px;
    }
    a{
        color: #333;
        text-decoration: none;
    }
    a:hover{
        color: red;
        text-decoration: none;
    }
</style>
<div style="padding-top: 20px;">
    <form>
        <div class="input-group" style="width: 90%; margin: auto;">
            <input type="text" class="form-control" name="keyword" id="keyword" value="" placeholder="在此输入地区或姓名" aria-describedby="btnSearch">
            <a class="input-group-addon" id="btnSearch" href="javascript:$('form').submit();"><i class="fa fa-search"></i></a>
        </div>
    </form>
</div>

<?php if(isset($items) && $items){ ?>
    <div style="background-color: #F1E9E1; margin: 20px; padding: 15px;">
        <ul class="list-group">
            <?php foreach($items as $item){ ?>
                <li class="list-group-item">
                    <a href="/home/view/<?php echo $item->id; ?>">
                        <div class="row">
                            <div class="col-xs-9">
                                <?php echo $item->country ? $item->country->name : '';?>
                                <?php echo $item->province ? $item->province->name : '';?>
                                <?php echo $item->city ? $item->city->name : '';?>
                            </div>
                            <div class="col-xs-3">
                                <?php echo $item->name;?>
                            </div>
                        </div>
                    </a>
                </li>
            <?php } ?>
        </ul>
        <div class="row">
            <div class="col-xs-6 text-right">
                <a href="javascript:;"><i class="fa fa-angle-left"></i> 上一页</a>
            </div>
            <div class="col-xs-6">
                <a href="javascript:;">下一页 <i class="fa fa-angle-right"></i></a>
            </div>
        </div>
    </div>
<?php }else{ ?>
    <img src="/assets/img/lotus.png" style="width: 100%;">
<?php } ?>

<script data-main="/assets/app/bootstrap" type="text/javascript" src="/assets/third-party/require/2.1.11/require.js"></script>