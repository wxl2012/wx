<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>

    <title>微信安全支付</title>

    <link href="/assets/third-party/bootstrap/3.3.5/css/bootstrap.min.css" />
    <style type="text/css">
        .alert .modal-dialog{
            width: 300px;
            margin: auto;
        }
        .alert .modal-dialog .modal-content .modal-footer{
            padding: 0px 0px;
            line-height: 40px;
        }
        .alert a{
            text-decoration: none !important;
            color: #508EF1 !important;
        }
        .bg-white{
            background-color: #fff;
            margin-bottom: 10px;
        }
        body{
            background-color: #efefef;
        }
        .container-fluid{
            padding: 0px;
        }
        .list-group .list-group-item:first-child{
            padding: 10px 0px;
        }
        .input-money{
            display: block;
            width: 100%;
            height: 34px;
            padding: 6px 12px;
            font-size: 14px;
            line-height: 1.42857143;
            color: #555;
            background-color: transparent;
            border: 0px;
            border-radius: 0px;
            outline:none;
        }
        .list-group .list-group-item:first-child, .list-group .list-group-item:last-child{
            border-bottom-left-radius: 0px;
            border-bottom-right-radius: 0px;
        }
    </style>
</head>
<body>

    <div class="container-fluid">
        <div class="row bg-white" style="line-height: 60px;">
            <div class="col-xs-12 text-center">
                <span style="font-size: 17pt; color: #5cb85c;">订单已提交</span>
            </div>
            <div class="col-xs-12 text-center" style="line-height: 15px; padding-bottom: 10px;">
                <p>(请在50分钟55秒内完成支付)</p>
                <p>商品合计: <span style="color:red;">8.00元</span></p>
            </div>
        </div>
        <div class="bg-white">
            <div class="list-group">
                <div class="list-group-item">
                    <input type="text" class="input-money" value="" placeholder="余额支付(余额: 0元)">
                </div>
                <div class="list-group-item" style="padding: 10px 0px;">
                    <input type="text" class="input-money" value="" placeholder="零钱支付(余额: 0元)">
                </div>
                <div class="list-group-item">
                    <div class="row">
                        <div class="col-xs-9">
                            其它支付方式
                        </div>
                        <div class="col-xs-3 text-right">
                            <span style="color:red;">8.00元</span>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <input type="radio" name="payment" value="wxpay"> 微信支付
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-default navbar-fixed-bottom">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 text-center">
                    <a id="btnPay" href="javascript:;" class="btn btn-danger" style="width: 100%;" data-toggle="modal" data-target="#payStatusModal">确认支付</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- 支付确认框 -->
    <div class="modal fade alert" id="payStatusModal" tabindex="-1" role="dialog" aria-labelledby="payStatusModalLabel">
        <div class="modal-dialog text-center" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <strong>请在微信支付完成支付！</strong>
                </div>
                <div class="modal-footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-6 text-center"><a href="javascript:;">重试</a></div>
                            <div class="col-xs-6 text-center" style="border-left: 1px solid #E5E5E5;"><a href="javascript:;">完成支付</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="/assets/third-party/jquery/1.12.0/jquery.min.js"></script>
    <script type="text/javascript" src="/assets/third-party/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <?php \Request::forge('/common/mp/jssdk')->execute();?>

    <script type="text/javascript">

        $(function(){
            $('#btnPay').click(function(){
                wx.ready(function(){
                    wx.chooseWXPay({
                        appId: "<?php echo $appId; ?>",
                        timestamp: "<?php echo $timeStamp; ?>",
                        nonceStr: "<?php echo $nonceStr; ?>",
                        package: "<?php echo $package; ?>",
                        signType: "<?php echo $signType; ?>",
                        paySign: "<?php echo $paySign; ?>",
                        success: function (res) {
                            window.location.href = "<?php echo \Input::get('to_url', false) ? urldecode(\Input::get('to_url')) : $to_url; ?>";
                        },
                        cancel: function(res){
                            window.location.href = "<?php echo \Input::get('to_url', false) ? urldecode(\Input::get('to_url')) : $to_url; ?>";
                        },
                        fail: function(res){
                            alert('支付时发生异常fail');
                        }
                    });
                });
            });
        });

    </script>
</body>
</html>