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
        #navTitle{
            font-size: 12pt;
        }
        input[type=text]{
            border: 0px;
            outline: none;
        }
    </style>

</head>

<body>

<?php if($client_type != 'wechat'){ ?>
    <nav class="navbar navbar-blue navbar-fixed-top">
        <div class="container">
            <div class="row">
                <div class="col-xs-3" id="navLeft" style="line-height: 50px;">
                    <a href="javascript:history.back(-1);"><i class="fa fa-angle-left" style="font-size: 1.5em;"></i></a>
                </div>
                <div class="col-xs-6 text-center" id="navTitle" style="line-height: 50px;">

                </div>
                <div class="col-xs-3 text-right" id="navRight" style="line-height: 50px;">

                </div>
            </div>
        </div>
    </nav>
    <div style="height: 50px;"></div>
<?php } ?>


<?php echo isset($content) ? $content : ''; ?>

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
</body>

</html>