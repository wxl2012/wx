<h3 class="header smaller lighter blue">
    微信公众号专项设置
    <small>粉丝分享、转发时的内容等</small>
</h3>

<div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="share_title"> 分享标题 </label>
    <div class="col-sm-9">
        <input type="text" class="col-xs-10 col-sm-5 col-md-7" id="share_title" name="share_title" placeholder="分享的标题" value="<?php echo isset($item) && $item ? $item->share_title : ''; ?>">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="share_url"> 链接地址 </label>
    <div class="col-sm-9">
        <input type="text" class="col-xs-10 col-sm-5 col-md-7" id="share_url" name="share_url" placeholder="点击分享时的链接" value="<?php echo isset($item) && $item ? $item->share_url : ''; ?>">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="share_image"> 分享图片 </label>
    <div class="col-sm-9">                  
        <div class="input-group col-xs-10 col-sm-7">
            <input type="text" class="form-control" id="share_image" name="share_image" placeholder="分享时的图片；外链地址或上传本地图片" value="<?php echo isset($item) && $item ? $item->share_image : ''; ?>">
            <span class="input-group-addon">
                <a href="#" data-panel="share_image" data-toggle="modal" data-target="#modal-upload"><i class="ace-icon fa fa-upload"></i></a>
            </span>
        </div>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="share_desc"> 描述 </label>
    <div class="col-sm-9">
        <textarea class="col-xs-10 col-sm-5 col-md-7" id="share_desc" name="share_desc" placeholder="分享时的描述"><?php echo isset($item) && $item ? $item->share_desc : ''; ?></textarea>
    </div>
</div>