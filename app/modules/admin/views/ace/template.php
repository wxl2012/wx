<?php $global = \Session::get('GLOBAL_PARAMS');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title><?php echo isset($title) ? $title : ''; ?> - Ace Admin</title>

    <meta name="description" content="overview &amp; stats" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <?php
    echo \Asset::css([
        'http://lib.sinaapp.com/js/bootstrap/v3.0.0/css/bootstrap.min.css',
        'font-awesome/4.5.0/css/font-awesome.min.css',
        'ace/css/ace-fonts.css',
        'ace/css/ace.css'
    ]);
    ?>
</head>

<body class="no-skin">
<?php echo render('ace/public/nav'); ?>
<div class="main-container" id="main-container">
    <script type="text/javascript">
        try{ace.settings.check('main-container' , 'fixed')}catch(e){}
    </script>

    <!-- #section:basics/sidebar -->
    <div id="sidebar" class="sidebar responsive">
        <script type="text/javascript">
            try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
        </script>

        <?php echo render('ace/public/shortcuts'); ?>

        <?php echo render('ace/public/left_menu'); ?>

        <!-- #section:basics/sidebar.layout.minimize -->
        <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
            <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
        </div>

        <!-- /section:basics/sidebar.layout.minimize -->
        <script type="text/javascript">
            try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
        </script>
    </div>
    <!-- /section:basics/sidebar -->

    <div class="main-content">
        <div class="main-content-inner">
            <?php echo render('ace/public/breadcrumbs'); ?>
            <div class="page-content">
                <?php echo render('ace/public/style_setting'); ?>

                <?php echo render('ace/public/page_header'); ?>

                <div class="row">
                    <div class="col-xs-12">
                        <!-- PAGE CONTENT BEGINS -->

                        <?php echo isset($content) ? $content : ''; ?>

                        <!-- PAGE CONTENT ENDS -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.page-content -->
        </div>
    </div><!-- /.main-content -->

    <?php echo render('ace/public/footer'); ?>

    <a href="javascript:;" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
        <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
    </a>
</div><!-- /.main-container -->

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

<!--[if lte IE 8]>
<script src="/assets/admin/ace/js/html5shiv.js"></script>
<script src="/assets/admin/ace/js/respond.js"></script>
<![endif]-->
<!-- basic scripts -->
<script type="text/javascript">
    if('ontouchstart' in document.documentElement) document.write("<script src='/assets/admin/ace/js/jquery.mobile.custom.js'>"+"<"+"/script>");
</script>
<?php
echo \Asset::js([
    'http://lib.sinaapp.com/js/bootstrap/v3.0.0/js/bootstrap.min.js',
    'ace/js/jquery-ui.custom.js',
    'ace/js/jquery.ui.touch-punch.js',
    'ace/js/jquery.easypiechart.js',
    'ace/js/jquery.sparkline.js',
    'ace/js/flot/jquery.flot.js',
    'ace/js/flot/jquery.flot.pie.js',
    'ace/js/flot/jquery.flot.resize.js',
    # ace scripts
    'ace/js/ace/elements.scroller.js',
    'ace/js/ace/elements.colorpicker.js',
    'ace/js/ace/elements.typeahead.js',
    'ace/js/ace/elements.wysiwyg.js',
    'ace/js/ace/elements.spinner.js',
    'ace/js/ace/elements.treeview.js',
    'ace/js/ace/elements.wizard.js',
    'ace/js/ace/elements.aside.js',
    'ace/js/ace/elements.fileinput.js',
    'ace/js/ace/ace.js',
    'ace/js/ace/ace.ajax-content.js',
    'ace/js/ace/ace.touch-drag.js',
    'ace/js/ace/ace.sidebar.js',
    'ace/js/ace/ace.sidebar-scroll-1.js',
    'ace/js/ace/ace.submenu-hover.js',
    'ace/js/ace/ace.widget-box.js',
    'ace/js/ace/ace.settings.js',
    'ace/js/ace/ace.settings-rtl.js',
    'ace/js/ace/ace.settings-skin.js',
    'ace/js/ace/ace.widget-on-reload.js',
    'ace/js/ace/ace.searchbox-autocomplete.js',
]);
?>
<!-- page specific plugin scripts -->

<!--[if lte IE 8]>
<script src="/assets/admin/ace/js/excanvas.js"></script>
<![endif]-->


<script type="text/javascript">
    var _share_title = '';
    var _share_url = '';
    var _share_img = '';
    var _share_desc = '';
    var _share_src = '';
</script>
<?php
    echo \Asset::render('css-files');
    echo \Asset::render('before-script');
    echo \Asset::render('js-files');
    echo \Asset::render('after-script');
?>

<?php echo \Request::forge('/common/mp/jssdk')->execute();?>
</body>
</html>
