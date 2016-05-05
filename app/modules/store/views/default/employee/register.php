<style type="text/css">
    .navbar-blue{
        background-color: #337ab7;
    }

    .list-group-item .row .col-xs-4{
        line-height: 30px;
        text-align: right;
    }

    .list-group-item:first-child{
        border-top-left-radius: 0px;
        border-top-right-radius: 0px;
    }
    .list-group-item:last-child{
        border-bottom-left-radius: 0px;
        border-bottom-right-radius: 0px;
    }
    body{
        background-color: #efefef;
    }
</style>

<?php if($client_type != 'wechat'){ ?>
    <nav class="navbar navbar-blue">
        <div class="container-fluid">
            <div class="row" style="line-height: 50px; margin-left: 0px; margin-right: 0px;">
                <div class="col-xs-2">
                    <a href="javascript:history.back();">
                        <i class="fa fa-angle-left" style="font-size: 2em; color: #fff;"></i>
                    </a>
                </div>
                <div class="col-xs-8 text-center" style="color: #fff; font-size: 13pt; font-weight: 600;">
                    注册成为职员
                </div>
                <div class="col-xs-2">
                </div>
            </div>
        </div>
    </nav>
<?php } ?>

<div class="container" style="padding-top: 15px;">
    <ul class="list-group">
        <li class="list-group-item">
            <div class="row">
                <div class="col-xs-4">
                    所属商户:
                </div>
                <div class="col-xs-8">
                    <?php echo '一号店商城';?>
                </div>
            </div>
        </li>
        <li class="list-group-item">
            <div class="row">
                <div class="col-xs-4">
                    姓名:
                </div>
                <div class="col-xs-8">
                    <input type="text" class="form-control" value="" placeholder="真实姓名" />
                </div>
            </div>
        </li>
        <li class="list-group-item">
            <div class="row">
                <div class="col-xs-4">
                    性别:
                </div>
                <div class="col-xs-8">
                    <select class="form-control">
                        <option value="male">先生</option>
                        <option value="female">女士</option>
                    </select>
                </div>
            </div>
        </li>
        <li class="list-group-item">
            <div class="row">
                <div class="col-xs-4">
                    年龄:
                </div>
                <div class="col-xs-8">
                    <input type="text" class="form-control" value="" placeholder="年龄" />
                </div>
            </div>
        </li>
    </ul>
    <div class="row">
        <div class="col-xs-12 text-center" style="padding-top: 10px;">
            <a class="btn btn-primary" style="width: 100%;" id="btnSubmit"> 提交资料</a>
        </div>
    </div>
</div>
<?php
$script = <<<js
js;

\Asset::js($script, [], 'before-script', true);

\Asset::js(['modules/trade/default/user/confirm_pay.js'], [], 'js-files', false);
?>
