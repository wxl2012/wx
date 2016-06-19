<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title><?php echo isset($title) && $title ? $title : ''; ?></title>

    <?php
    echo \Asset::css([
        'http://lib.sinaapp.com/js/bootstrap/v3.0.0/css/bootstrap.min.css',
        'font-awesome/4.5.0/css/font-awesome.min.css'
    ]);
    ?>

    <style type="text/css">
        .ns-effect-genie{
            bottom: 55px !important;
            background-color: #d9534f !important;
        }
        
        .ns-effect-genie .ns-close::after, .ns-effect-genie .ns-close::before{
            background-color: #efefef !important;
        }
    </style>

</head>

<body>

<?php echo $content; ?>


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
echo \Asset::js([
    'http://lib.sinaapp.com/js/jquery/1.10.2/jquery-1.10.2.min.js',
    'http://lib.sinaapp.com/js/bootstrap/v3.0.0/js/bootstrap.min.js',
]);
echo \Asset::render('js-files');
echo \Asset::render('after-script');
?>

<?php echo \Request::forge('/common/mp/jssdk')->execute();?>
</body>
</html>