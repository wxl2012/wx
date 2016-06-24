<?php
$seller = \Session::get('seller', false);
?>
<div class="row">
    <div class="col-xs-12">
        <div class="alert alert-danger" style="display:none; text-align: center; font-size:20px;" id="ajaxResult"></div>
        <!-- PAGE CONTENT BEGINS -->
        <form class="form-horizontal" method="post" role="form">

            <h4 class="header purple">
                <i class="ace-icon fa fa-tachometer purple"></i>
                公众号基础信息
                <small>基本信息</small>
            </h4>

            <!-- #section:elements.form -->
            <?php if(Auth::has_access('admin.wxaccount[show_seller]')){ ?>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="seller_id"> 所属商户 </label>
                    <div class="col-sm-9">
                        <input type="text" class="col-xs-10 col-sm-5 col-md-7" id="seller_id" name="seller_id" placeholder="商户ID" value="<?php echo isset($item) && $item ? $item->seller_id : ''; ?>">
                    </div>
                </div>
            <?php } ?>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="nickname"> 公众号名称 </label>
                <div class="col-sm-9">
                    <input type="text" class="col-xs-10 col-sm-5 col-md-7" id="nickname" name="nickname" placeholder="公众号名称" value="<?php echo isset($item) && $item ? $item->nickname : ''; ?>">
                </div>
            </div>

            <h4 class="header blue">
                <i class="ace-icon fa fa-random blue"></i>
                接口调用凭证
                <small>发布自定义菜单、获取粉丝信息、微信支付等接口凭证</small>
            </h4>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="open_id"> openid </label>
                <div class="col-sm-9">
                    <input type="text" class="col-xs-10 col-sm-5 col-md-7" id="open_id" name="open_id" placeholder="原始ID"  value="<?php echo isset($item) && $item ? $item->open_id : ''; ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="app_id"> AppID </label>
                <div class="col-sm-9">
                    <input type="text" class="col-xs-10 col-sm-5 col-md-7" id="app_id" name="app_id" placeholder="AppID(应用ID)"  value="<?php echo isset($item) && $item ? $item->app_id : ''; ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="app_secret"> AppSecret </label>
                <div class="col-sm-9">
                    <input type="text" class="col-xs-10 col-sm-5 col-md-7" id="app_secret" name="app_secret" placeholder="AppSecret(应用密钥)"  value="<?php echo isset($item) && $item ? $item->app_secret : ''; ?>">
                </div>
            </div>

            <h4 class="header green">
                <i class="ace-icon fa fa-hand-o-right green"></i>
                协助管理信息
                <small>需要技术人员协助处理时使用</small>
            </h4>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="username"> 用户名 </label>
                <div class="col-sm-9">
                    <input type="text" class="col-xs-10 col-sm-5 col-md-7" id="username" name="username" placeholder="微信公众平台的用户名"  value="<?php echo isset($item) && $item ? $item->username : ''; ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="password"> 密码 </label>
                <div class="col-sm-9">
                    <input type="text" class="col-xs-10 col-sm-5 col-md-7" id="password" name="password" placeholder="微信公众平台的密码" value="<?php echo isset($item) && $item ? $item->password : ''; ?>">
                </div>
            </div>

            <h4 class="header green">
                <i class="ace-icon fa fa-puzzle-piece green"></i>
                接入信息
                <small>接入本平台信息查看及加密设置</small>
            </h4>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="url"> URL地址 </label>
                <div class="col-sm-9">
                    <input type="text" class="col-xs-10 col-sm-5 col-md-7" id="url" placeholder="提交后可查看" readonly value="<?php echo isset($item) && $item ? \Config::get('base_url') . "wxapi/action/{$item->id}" : ''; ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> token </label>
                <div class="col-sm-9">
                    <input type="text" class="col-xs-10 col-sm-5 col-md-7" id="token" name="token" placeholder="对接时的token" readonly value="<?php echo isset($item) && $item ? $item->token : md5(time() . 'ray'); ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="encoding_aes_key"> 加解密密钥 </label>
                <div class="col-sm-9">
                    <input type="text" class="col-xs-10 col-sm-5 col-md-7" id="encoding_aes_key" name="encoding_aes_key" placeholder="加解密密钥"  value="<?php echo isset($item) && isset($item->encoding_aes_key) ? $item->encoding_aes_key : ''; ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="status"> 接入状态 </label>
                <div class="col-sm-9">
                    <select name="status" id="status">
                        <option value="NONE"<?php echo isset($item) && $item && $item->status == 'NONE' ? ' selected="selected"' : ''; ?>>准备接入</option>
                        <option value="ACTIVED"<?php echo isset($item) && $item && $item->status == 'ACTIVED' ? ' selected="selected"' : ''; ?>>已接入</option>
                    </select>
                </div>
            </div>

            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button class="btn btn-info" type="submit">
                        <i class="ace-icon fa fa-check bigger-110"></i>
                        提交
                    </button>

                    &nbsp; &nbsp; &nbsp;
                    <button class="btn" type="reset">
                        <i class="ace-icon fa fa-undo bigger-110"></i>
                        重置
                    </button>
                </div>
            </div>
        </form><!-- PAGE CONTENT ENDS -->
    </div><!-- /.col -->
</div><!-- /.row -->

<?php echo render('ace/public/alert_message'); ?>

<script type="text/javascript">
    var path = 'activity';
    var imgpanel = '';
    var is_exist = false;

    function callback(file, data){
        var json = eval('(' + data + ')');
        if(json.status == 'succ'){
            $("#thumbnail").val(json.data);
        }else{
            alert(json.msg);
        }
    }

    $(function(){
        <?php if(! isset($item) || ! $item){ ?>
        $('#open_id').blur(function(){
            $.get('/admin/wxaccount/exist/open_id/' + $(this).val(),
                function(data){
                    if(data.status == 'err'){
                        alert('检查open_id时发生异常');
                        return;
                    }
                    is_exist = data.data;
                    if(data.data == true){

                        $('#openid').parents('.form-group').addClass('has-error');
                        $('#ajaxResult').html('<i class="fa fa-exclamation-circle" style="font-size:25px;"></i> 该公众号已被其它商户绑定，请确认原始ID正确！').show();
                    }
                }, 'json');
        });
        <?php } ?>


        $('button[type="submit"]').click(function(){
            if(is_exist){
                return false;
            }

        });
    });

</script>
<?php //echo render('tools/upload'); ?>

