
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>系统提示 - <?php echo isset($GLOBAL_OPTIONS['site_admin_name']) ? $GLOBAL_OPTIONS['site_admin_name'] : '未设置'; ?></title>

    <meta name="description" content="User login page" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <?php
    echo \Asset::css([
        'http://lib.sinaapp.com/js/bootstrap/v3.0.0/css/bootstrap.min.css',
        'font-awesome/4.5.0/css/font-awesome.min.css',
        'ace/css/ace-fonts.css',
    ]);
    ?>

    <!-- ace styles -->
    <link rel="stylesheet" href="/assets/admin/ace/css/ace.css" class="ace-main-stylesheet" id="main-ace-style" />

    <!--[if lte IE 9]>
    <link rel="stylesheet" href="/assets/admin/ace/css/ace-part2.css" class="ace-main-stylesheet" />
    <![endif]-->

    <!--[if lte IE 9]>
    <link rel="stylesheet" href="/assets/admin/ace/css/ace-ie.css" />
    <![endif]-->
</head>

<body>
<div class="main-container">
    <div class="main-content">
        <div class="row">
            <div class="col-xs-2"></div>
            <div class="col-xs-8">
                <!-- PAGE CONTENT BEGINS -->
                <?php $msg = \Session::get_flash('msg'); ?>
                <!-- #section:pages/error -->
                <div class="error-container">
                    <div class="well">
                        <h1 class="grey lighter smaller">
                            <span class="blue bigger-125"<?php echo isset($msg['color']) ?  "style=\"color: {$msg['color']} !important\"" : '';?>>
                                <i class="ace-icon fa fa-<?php echo isset($msg['icon']) ?  $msg['icon'] : 'random';?>"></i>
                                <?php echo $msg['title']; ?>
                            </span>
                            <?php echo $msg['sub_title']; ?>
                        </h1>

                        <hr>
                        <h3 class="lighter smaller hide">
                            But we are working
                            <i class="ace-icon fa fa-wrench icon-animated-wrench bigger-125"></i>
                            on it!
                        </h3>

                        <div class="space"></div>

                        <div>
                            <h4 class="lighter smaller"><?php echo $msg['msg']; ?></h4>

                            <ul class="list-unstyled spaced inline bigger-110 margin-15">
                                <li>
                                    <i class="ace-icon fa fa-hand-o-right blue"></i>
                                    请确认您的帐户是后台管理类帐户
                                </li>

                                <li>
                                    <i class="ace-icon fa fa-hand-o-right blue"></i>
                                    您可以联络超级管理员了解详情
                                </li>
                            </ul>
                        </div>

                        <hr>
                        <div class="space"></div>

                        <div class="center">
                            <a href="javascript:history.back()" class="btn btn-grey">
                                <i class="ace-icon fa fa-arrow-left"></i>
                                后退
                            </a>

                            <a href="/" class="btn btn-primary">
                                <i class="ace-icon fa fa-home"></i>
                                返回主页
                            </a>
                        </div>
                    </div>
                </div>

                <!-- /section:pages/error -->

                <!-- PAGE CONTENT ENDS -->
            </div><!-- /.col -->
            <div class="col-xs-2">
            </div>
        </div><!-- /.row -->
    </div><!-- /.main-content -->
</div><!-- /.main-container -->
<!-- basic scripts -->
</body>
</html>
