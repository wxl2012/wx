<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title><?php echo isset($title) ? $title : ''; ?> - 公众帐户第三方服务平台</title>

    <meta name="description" content="overview &amp; stats" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <meta name="author" content="易微信"/>

    <!-- bootstrap & fontawesome -->
    <link href="/assets/third-party/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" />


    <style type="text/css">
        body{
            margin: 0px;
            padding: 0px;
        }
        .br{
            border-right:1px solid #c0c0c0;
        }
        .tac{
            text-align: center;
        }
        .row{
            margin: 0px;
        }
        .list-group{
            margin-bottom: 0px;
        }
        .list-group-item{
            padding: 0px;
        }
        .list-group-item input{
            height: 44px;
            width: 100%;
        }
        .list-group-item-last{
            border-bottom-right-radius: 0px !important;
            border-bottom-left-radius: 0px !important;
        }
        input, input:hover{
            width: 100%;
            border: 0px;
            text-align: center;
        }
    </style>
</head>

<body>
<div class="container-fluid" style="height:100%; width:100%; padding: 0px;">
    <div id="submenu-item" class="row" style="height: 316px; background-color: #ebebeb;">
        <?php if(isset($items) && $items){?>
            <?php $index = 0; ?>
            <?php foreach ($items->button as $key => $value) { ?>
                <div id="submenuItem<?php echo $index ++; ?>" class="col-xs-<?php echo 12 / count($items->button); ?>" style="padding:0px; margin-top: 90px">
                    <ul class="list-group">
                        <?php $i = 0; ?>
                        <?php if(isset($value->sub_button) && $value->sub_button){ ?>
                            <?php $i = count($value->sub_button); ?>
                            <?php foreach ($value->sub_button as $key => $value) { ?>
                                <li class="list-group-item"><input type="text" value="<?php echo $value->name; ?>" placeholder="子菜单1" data='<?php echo json_encode($value); ?>'></li>
                            <?php }?>
                        <?php } ?>

                        <?php for (; $i < 5; $i ++) { ?>
                            <li class="list-group-item<?php echo $i + 1 == 5 ? ' list-group-item-last' : ''; ?>"><input type="text" value=""  data='{"category": 0, "type":0,"name":"","url":"","key":"","media_id":"","sub_button":[]}' placeholder="子菜单<?php echo $i + 1; ?>"></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>
        <?php }else{ ?>
            <div id="submenuItem0" class="col-xs-12" style="padding:0px; margin-top: 90px">
                <ul class="list-group">
                    <li class="list-group-item"><input type="text" value="" placeholder="子菜单1" data='{"category": 0, "type":0,"name":"","url":"","key":"","media_id":"","sub_button":[]}'></li>
                    <li class="list-group-item"><input type="text" value="" placeholder="子菜单2" data='{"category": 0, "type":0,"name":"","url":"","key":"","media_id":"","sub_button":[]}'></li>
                    <li class="list-group-item"><input type="text" value="" placeholder="子菜单3" data='{"category": 0, "type":0,"name":"","url":"","key":"","media_id":"","sub_button":[]}'></li>
                    <li class="list-group-item"><input type="text" value="" placeholder="子菜单4" data='{"category": 0, "type":0,"name":"","url":"","key":"","media_id":"","sub_button":[]}'></li>
                    <li class="list-group-item list-group-item-last"><input type="text" value="" placeholder="子菜单5" data='{"category": 0, "type":0,"name":"","url":"","key":"","media_id":"","sub_button":[]}'></li>
                </ul>
            </div>
        <?php } ?>
    </div>
    <div id="menu-item" class="row" style="background-color: #fff; line-height: 48px; border-top:1px solid #c0c0c0;">
        <?php if(isset($items) && $items){ ?>
            <?php $index = 0; ?>
            <?php foreach ($items->button as $key => $value) { ?>
                <?php
                $content = '';
                if(isset($value->type) && $value->type){
                    $content = $value->type == 'view' ? $value->url : $value->key;
                }
                ?>
                <div id="menuItem<?php echo $index ++; ?>" class="col-xs-<?php echo 12 / count($items->button); ?> text-center <?php echo $index < (12 / (12 / count($items->button))) ? ' br' : ''; ?>" action="menu-item" style="padding: 0px;">
                    <input type="text" placeholder="一级菜单" style=" line-height: 48px;" data='<?php echo json_encode($value); ?>' value="<?php echo $value->name; ?>"/>
                </div>
            <?php } ?>
        <?php }else{ ?>
            <div id="menuItem0" class="col-xs-12 tac"  data='{"category": 0, "type":0,"name":"","url":"","key":"","media_id":"","sub_button":[]}' action="menu-item" style="padding: 0px;">
                <input type="text" placeholder="一级菜单" style=" line-height: 48px;"/>
            </div>
        <?php } ?>
    </div>
</div>

<script type="text/x-jquery-tmpl" id="menuItemHtml">
    <div class="col-xs-12 tac" id="menuItem${index}" data='{"category": 0, "type":0,"name":"","url":"","key":"","media_id":"","sub_button":[]}' action="menu-item" style="padding: 0px;">
        <input type="text" value="" placeholder="一级菜单" />
    </div>
</script>

<script type="text/x-jquery-tmpl" id="menuHtml">
    <div class="col-xs-12" id="submenuItem${index}" style="padding:0px; margin-top: 90px">
        <ul class="list-group">
            <li class="list-group-item"><input type="text" value="" placeholder="子菜单1"></li>
            <li class="list-group-item"><input type="text" value="" placeholder="子菜单2"></li>
            <li class="list-group-item"><input type="text" value="" placeholder="子菜单3"></li>
            <li class="list-group-item"><input type="text" value="" placeholder="子菜单4"></li>
            <li class="list-group-item list-group-item-last"><input type="text" value="" placeholder="子菜单5"></li>
        </ul>
    </div>
</script>

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

<script type="text/javascript">
    var wx_account_id = <?php echo \Session::get('WXAccount')->id; ?>;
</script>

<?php
echo \Asset::js([
    'http://lib.sinaapp.com/js/bootstrap/v3.0.0/js/bootstrap.min.js',
    'jquery-tmpl/jquery.tmpl.min.js',
    'jquery-tmpl/jquery.tmplPlus.min.js',
    'tools.js',
    'mp/menu/moblie.js'
]);
?>
</body>
</html>