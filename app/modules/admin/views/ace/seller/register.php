<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title> 注册企业信息 - <?php echo isset($GLOBAL_OPTIONS['site_admin_name']) ? $GLOBAL_OPTIONS['site_admin_name'] : '未设置'; ?></title>

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

<body class="login-layout blur-login">
<div class="main-container">
    <div class="main-content">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="login-container">
                    <div class="center">
                        <h1>
                            <i class="ace-icon fa fa-leaf green"></i>
                            <span class="red"><?php echo isset($GLOBAL_OPTIONS['site_web_short_name']) ? $GLOBAL_OPTIONS['site_web_short_name'] : '';?></span>
                            <span class="white" id="id-text2">管理平台</span>
                        </h1>
                        <h4 class="blue" id="id-company-text">&copy; <?php echo isset($GLOBAL_OPTIONS['site_company_full_name']) ? $GLOBAL_OPTIONS['site_company_full_name'] : '';?></h4>
                    </div>

                    <div class="space-6"></div>

                    <div class="position-relative">
                        <div id="signup-box" class="signup-box widget-box no-border">
                            <div class="widget-body">
                                <div class="widget-main">
                                    <h4 class="header green lighter bigger">
                                        <i class="ace-icon fa fa-users blue"></i>注册新用户</h4>
                                    <div class="space-6"></div>
                                    <p>请填写以下注册信息:</p>
                                    <form>
                                        <fieldset>
                                            <label class="block clearfix">
							<span class="block input-icon input-icon-right">
								<select class="form-control">
									<option>手机注册</option>
									<option>邮箱注册</option></select>
							</span>
                                            </label>
                                            <label class="block clearfix" style="display:none;">
							<span class="block input-icon input-icon-right">
								<input type="email" class="form-control" placeholder="安全邮箱" />
								<i class="ace-icon fa fa-envelope"></i>
							</span>
                                            </label>
                                            <label class="block clearfix">
							<span class="block input-icon input-icon-right">
								<input type="text" class="form-control" placeholder="手机号码" />
								<i class="ace-icon fa fa-mobile" style="font-size: 2em"></i>
							</span>
                                            </label>
                                            <!--<label class="block clearfix">
                                            <span class="block input-icon input-icon-right">
                                            <input type="text" class="form-control" placeholder="请输入一个用户名" />
                                            <i class="ace-icon fa fa-user"></i></span>
                                            </label>-->
                                            <label class="block clearfix">
							<span class="block input-icon input-icon-right">
								<input type="password" class="form-control" placeholder="请输入密码" />
								<i class="ace-icon fa fa-lock"></i>
							</span>
                                            </label>
                                            <label class="block clearfix">
							<span class="block input-icon input-icon-right">
								<input type="password" class="form-control" placeholder="确认密码" />
								<i class="ace-icon fa fa-retweet"></i>
							</span>
                                            </label>
                                            <label class="block">
                                                <input type="checkbox" class="ace" />
							<span class="lbl">我同意
								<a href="#">
									<?php echo isset($GLOBAL_OPTIONS[ 'site_admin_name']) ? $GLOBAL_OPTIONS[ 'site_admin_name'] : ''; ?></a></span>
                                            </label>
                                            <div class="space-24"></div>
                                            <div class="clearfix">
                                                <button type="reset" class="width-30 pull-left btn btn-sm">
                                                    <i class="ace-icon fa fa-refresh"></i>
                                                    <span class="bigger-110">重置</span></button>
                                                <button type="button" class="width-65 pull-right btn btn-sm btn-success">
                                                    <span class="bigger-110">注册</span>
                                                    <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
                                                </button>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                                <div class="toolbar center">
                                    <a href="#" data-target="#login-box" class="back-to-login-link">
                                        <i class="ace-icon fa fa-arrow-left"></i>返回登录页</a>
                                </div>
                            </div>
                            <!-- /.widget-body --></div>
                        <!-- /.signup-box --></div>
                    <!-- /.position-relative -->

                    <div class="navbar-fixed-top align-right">
                        <br />
                        &nbsp;
                        <a id="btn-login-dark" href="#">黑暗</a>
                        &nbsp;
                        <span class="blue">/</span>
                        &nbsp;
                        <a id="btn-login-blur" href="#">模糊</a>
                        &nbsp;
                        <span class="blue">/</span>
                        &nbsp;
                        <a id="btn-login-light" href="#">高亮</a>
                        &nbsp; &nbsp; &nbsp;
                    </div>
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.main-content -->
</div><!-- /.main-container -->
<!-- basic scripts -->

<script type="text/javascript" src="http://lib.sinaapp.com/js/jquery/1.10.2/jquery-1.10.2.min.js"></script>
<!--[if !IE]> -->
<script type="text/javascript">
    window.jQuery || document.write("<script src='/assets/third-party/jquery/1.10.2/jquery.min.js'>"+"<"+"/script>");
</script>
<!-- <![endif]-->

<!--[if IE]>
<script type="text/javascript">
    window.jQuery || document.write("<script src='/assets/admin/ace/js/jquery1x.js'>"+"<"+"/script>");
</script>
<![endif]-->


<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

<!--[if lt IE 9]>
<script src="/assets/admin/ace/js/html5shiv.js"></script>
<script src="/assets/admin/ace/js/respond.js"></script>
<![endif]-->

<script type="text/javascript">
    if('ontouchstart' in document.documentElement) document.write("<script src='/assets/admin/ace/js/jquery.mobile.custom.js'>"+"<"+"/script>");
</script>

<!-- inline scripts related to this page -->
<script type="text/javascript">
    jQuery(function($) {
        $(document).on('click', '.toolbar a[data-target]', function(e) {
            e.preventDefault();
            var target = $(this).data('target');
            $('.widget-box.visible').removeClass('visible');//hide others
            $(target).addClass('visible');//show target
        });
    });



    //you don't need this, just used for changing background
    jQuery(function($) {
        $('#btn-login-dark').on('click', function(e) {
            $('body').attr('class', 'login-layout');
            $('#id-text2').attr('class', 'white');
            $('#id-company-text').attr('class', 'blue');

            e.preventDefault();
        });
        $('#btn-login-light').on('click', function(e) {
            $('body').attr('class', 'login-layout light-login');
            $('#id-text2').attr('class', 'grey');
            $('#id-company-text').attr('class', 'blue');

            e.preventDefault();
        });
        $('#btn-login-blur').on('click', function(e) {
            $('body').attr('class', 'login-layout blur-login');
            $('#id-text2').attr('class', 'white');
            $('#id-company-text').attr('class', 'light-blue');

            e.preventDefault();
        });

    });
</script>
</body>
</html>
