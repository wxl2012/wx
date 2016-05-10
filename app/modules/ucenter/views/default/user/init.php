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
    input[type=text],input[type=email], select{
        border: 0px;
        outline: none;
    }
    .list-group-item .row .col-xs-3{
        line-height: 30px;
        text-align: right;
    }
</style>
<nav class="navbar navbar-blue navbar-fixed-top">
    <div class="container">
        <div class="row">
            <div class="col-xs-3" style="line-height: 50px;">
                <a href="javascript:history.back(-1);"><i class="fa fa-angle-left" style="font-size: 1.5em;"></i></a>
            </div>
            <div class="col-xs-6 text-center" style="line-height: 50px;">
                注册会员
            </div>
            <div class="col-xs-3 text-right" style="line-height: 50px;">
            </div>
        </div>
    </div>
</nav>

<div style="height: 55px;"></div>

<div class="list-group">
    <div class="list-group-item text-center">
        <p>
            <img src="/uploads/tmp/head.png" alt="" style="width: 80px;" class="img-circle"/>
        </p>
        <p style="font-size: 14pt;">waydea2010</p>
    </div>
</div>

<form id="frmReg">

    <div class="list-group">
        <div class="list-group-item">
            <div class="row">
                <div class="col-xs-3">
                    用户名
                </div>
                <div class="col-xs-9" style="padding-right: 2px;">
                    <input type="text" class="form-control" id="username" name="username" value="" placeholder="用于登录的用户名" />
                </div>
            </div>
        </div>
        <div class="list-group-item">
            <div class="row">
                <div class="col-xs-3">
                    密&nbsp;&nbsp;&nbsp;&nbsp;码
                </div>
                <div class="col-xs-9">
                    <input type="text" class="form-control" id="password" name="password" value="" placeholder="用于登录的密码" />
                </div>
            </div>
        </div>
    </div>

    <div class="list-group">
        <div class="list-group-item">
            <div class="row">
                <div class="col-xs-3">
                    姓名
                </div>
                <div class="col-xs-4" style="padding-right: 2px;">
                    <input type="text" class="form-control" id="first_name" name="first_name" value="" placeholder="姓氏" />
                </div>
                <div class="col-xs-5" style="padding-left: 2px;">
                    <input type="text" class="form-control" id="last_name" name="last_name" value="" placeholder="名称" />
                </div>
            </div>
        </div>
        <div class="list-group-item">
            <div class="row">
                <div class="col-xs-3">
                    性别
                </div>
                <div class="col-xs-9">
                    <select class="form-control" id="gender" name="gender">
                        <option value="male">先生</option>
                        <option value="famale">女士</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="list-group-item">
            <div class="row">
                <div class="col-xs-3">
                    出生日期
                </div>
                <div class="col-xs-9">
                    <input type="text" class="form-control" id="birthday" name="birthday" value="" placeholder="YYYY-MM-DD">
                </div>
            </div>
        </div>
        <div class="list-group-item">
            <div class="row">
                <div class="col-xs-3">
                    手机号
                </div>
                <div class="col-xs-9">
                    <input type="text" class="form-control" id="phone" name="phone" value="" placeholder="">
                </div>
            </div>
        </div>
        <div class="list-group-item">
            <div class="row">
                <div class="col-xs-3">
                    邮箱
                </div>
                <div class="col-xs-9">
                    <input type="email" class="form-control" id="email" name="email" value="" placeholder="邮箱地址">
                </div>
            </div>
        </div>
    </div>

    <div style="display: none;">
        <div class="alert alert-danger text-center" id="errorMsg">

        </div>
    </div>

    <div class="text-center">
        <a class="btn btn-primary" style="width: 90%;" id="btnSubmit">注册会员</a>
    </div>
</form>

<?php
$script = <<<js
js;

\Asset::js($script, [], 'before-script', true);
\Asset::js(['modules/ucenter/default/user/init.js'], [], 'js-files', false);

?>