<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>系统登录 - <?php echo isset($GLOBAL_OPTIONS['site_admin_name']) ? $GLOBAL_OPTIONS['site_admin_name'] : '未设置'; ?></title>

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
                        <div id="login-box" class="login-box visible widget-box no-border">
                            <div class="widget-body">
                                <div class="widget-main">
                                    <h4 class="header blue lighter bigger">
                                        <i class="ace-icon fa fa-coffee green"></i>
                                        请输入您的信息
                                    </h4>

                                    <div class="space-6"></div>

                                    <form method="post">
                                        <fieldset>
                                            <label class="block clearfix">
													<span class="block input-icon input-icon-right">
														<input type="text" id="username" name="username" class="form-control" placeholder="用户名/邮箱/手机号" />
														<i class="ace-icon fa fa-user"></i>
													</span>
                                            </label>

                                            <label class="block clearfix">
													<span class="block input-icon input-icon-right">
														<input type="password" id="password" name="password" class="form-control" placeholder="密码" />
														<i class="ace-icon fa fa-lock"></i>
													</span>
                                            </label>

                                            <div class="space"></div>

                                            <div class="clearfix">
                                                <label class="inline">
                                                    <input type="checkbox" class="ace" />
                                                    <span class="lbl"> 记住密码</span>
                                                </label>

                                                <button type="submit" class="width-35 pull-right btn btn-sm btn-primary">
                                                    <i class="ace-icon fa fa-key"></i>
                                                    <span class="bigger-110">登录</span>
                                                </button>
                                            </div>

                                            <div class="space-4"></div>
                                            <p class="help-block" style="color: #d9534f">
                                                <?php
                                                $msg = \Session::get_flash('msg', false);
                                                if($msg){
                                                    echo $msg['msg'];
                                                }
                                                ?>
                                            </p>
                                        </fieldset>
                                    </form>

                                    <!--<div class="social-or-login center">
                                        <span class="bigger-110">合作方登录</span>
                                    </div>

                                    <div class="space-6"></div>

                                    <div class="social-login center">

                                        <a class="btn btn-success">
                                            <i class="ace-icon fa fa-wechat"></i>
                                        </a>
                                        <a class="btn btn-primary" href="/home/qq_login">
                                            <i class="ace-icon fa fa-qq"></i>
                                        </a>

                                        <a class="btn btn-info">
                                            <i class="ace-icon fa fa-weibo"></i>
                                        </a>

                                        <a class="btn btn-danger">
                                            <i class="ace-icon fa fa-renren"></i>
                                        </a>
                                    </div>-->
                                </div><!-- /.widget-main -->

                                <div class="toolbar clearfix">
                                    <div>
                                        <a href="#" data-target="#forgot-box" class="forgot-password-link">
                                            <i class="ace-icon fa fa-arrow-left"></i>
                                            忘记密码
                                        </a>
                                    </div>

                                    <div>
                                        <a href="#" data-target="#signup-box" class="user-signup-link">
                                            注册帐户
                                            <i class="ace-icon fa fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div><!-- /.widget-body -->
                        </div><!-- /.login-box -->


                        <?php echo render('ace/public/login_forget'); ?>

                        <?php echo render('ace/public/login_reg'); ?>
                    </div><!-- /.position-relative -->

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
