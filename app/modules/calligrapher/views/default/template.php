<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title><?php echo isset($title) && $title ? $title : ''; ?></title>

    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/third-party/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">

    <style type="text/css">
        body{
            background: url('/assets/img/bg.png');
        }
        .top{
            background-color: #3f3d3b;
            color: #fff;
            font-family: 微软雅黑;
            letter-spacing: 10px;
            font-size: 20pt;
        }
        .bottom{
            background-color: #69645f;
            color: #fff;
            height: 140px;
        }
    </style>
</head>

<body>


    <div class="top">
        <div style="padding: 10px;">
            <img src="/assets/img/company.png" alt="" style="width: 60%;"/>
        </div>
        <p class="text-center" style="padding-bottom: 20px;">
            <img src="/assets/img/title.png" alt="" style="width: 80%;">
        </p>
    </div>

    <?php echo $content; ?>

    <div class="bottom">
        <img src="/assets/img/eaves.png" alt="" style="width: 100%;"/>
        <p class="text-center" style="padding-top: 20px;">
            版权所有:中国硬笔书法协会办学指导中心
        </p>
        <p class="text-center">
            Copyright &copy;ybsf.cn. All Rights Reserved. 豫ICP证080047号
        </p>
    </div>

    <script type="text/javascript" src="/assets/third-party/jquery/1.12.0/jquery.min.js"></script>
    <script type="text/javascript" src="/assets/js/bootstrap.min.js"></script>
</body>
</html>