<?php
$seller = \Session::get('seller', false);
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title><?php echo isset($title) ? $title : ''; ?>-<?php echo $seller ? $seller->short_name : '';?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <meta name="keywords" content="<?php echo $seller && isset($seller->keywords) && $seller->keywords ? $seller->keywords : ''; ?>">
    <meta name="description" content="<?php echo $seller && isset($seller->description) && $seller->description ? $seller->description : ''; ?>">
    <link href="/assets/third-party/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/third-party/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="/assets/css/wayde_callout.css">
</head>

<body>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <?php
            $msg = \Session::get_flash('msg');
            ?>
            <h3 class="text-center">
                <?php echo isset($msg['title']) ? $msg['title'] : '发生异常!'; ?>
            </h3>

            <div class="bs-callout bs-callout-danger">
                <h4><?php echo isset($msg['title']) ? $msg['title'] : ''; ?>信息：</h4>
                <?php echo $msg['msg']; ?>
            </div>

            <div class="text-center">
                <a id="btnReturn" class="btn btn-primary" href="javascript:history.back();">返回</a>
                <a id="btnClose" class="btn btn-danger">关闭</a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="/assets/third-party/jquery/1.12.0/jquery.min.js"></script>
<script type="text/javascript" src="/assets/third-party/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<?php \Request::forge('/common/mp/jssdk')->execute();?>

<script type="text/javascript">
    $(function(){
        $('#btnClose').click(function(){
            if(wx != undefined){
                wx.closeWindow();
            }else{
                window.close();
            }
        });
    });
</script>
</body>

</html>