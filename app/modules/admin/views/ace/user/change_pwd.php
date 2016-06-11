<?php
$seller = \Session::get('seller', false);
?>
<div class="row">
    <div class="col-xs-12">
        <div class="alert alert-danger" style="display:none; text-align: center; font-size:20px;" id="ajaxResult"></div>
        <!-- PAGE CONTENT BEGINS -->
        <form class="form-horizontal" method="post" role="form">
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="password"> 原密码 </label>
                <div class="col-sm-9">
                    <input type="password" class="col-xs-10 col-sm-5 col-md-7" id="password" name="password" placeholder="当前密码" value="">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="newpwd"> 新密码 </label>
                <div class="col-sm-9">
                    <input type="password" class="col-xs-10 col-sm-5 col-md-7" id="newpwd" name="new_password" placeholder="新密码" value="">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="repwd"> 确认密码 </label>
                <div class="col-sm-9">
                    <input type="password" class="col-xs-10 col-sm-5 col-md-7" id="repwd" name="repwd" placeholder="确认新密码" value="">
                </div>
            </div>

            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button class="btn btn-info" type="submit">
                        <i class="ace-icon fa fa-check bigger-110"></i>
                        确认修改
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

