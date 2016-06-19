<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta http-equiv=Content-Type content="text/html;charset=utf-8">
    <meta http-equiv=X-UA-Compatible content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <link rel="shortcut icon" href=""/>

    <title><?php echo isset($title) ? $title : ''; ?></title>

    <?php
    echo \Asset::css([
        'http://lib.sinaapp.com/js/bootstrap/v3.0.0/css/bootstrap.min.css',
        'font-awesome/4.5.0/css/font-awesome.min.css'
    ]);

    ?>
</head>

<body>
<?php echo isset($content) ? $content : ''; ?>

<?php
echo \Asset::render('css-files');
echo \Asset::render('before-script');
echo \Asset::js([
    'jquery/1.12.0/jquery.min.js',
    'bootstrap/3.3.5/js/bootstrap.min.js'
    //'http://lib.sinaapp.com/js/jquery/1.10.2/jquery-1.10.2.min.js',
    //'http://lib.sinaapp.com/js/bootstrap/v3.0.0/js/bootstrap.min.js',
]);
echo \Asset::render('js-files');
echo \Asset::render('after-script');
?>
</body>

</html>