<div class="row">
    <div class="col-xs-6">
        <select id="account_id" name="account_id">
            <option></option>
        </select>
    </div>
    <div class="col-xs-6">
        <div class="clearfix" style="text-align: right; padding-right: 12px;">
            <div class="btn-group" role="group" aria-label="First group">
                <!--<button type="button" class="btn btn-default"><i class="fa fa-search"></i></button>-->
                <a href="javascript:;" id="btnAdd" class="btn btn-sm btn-default"><i class="fa fa-plus"></i></a>
                <!--<button type="button" class="btn btn-default"><i class="fa fa-file-excel-o"></i></button>-->
                <a href="javascript:;" id="btnSyn" class="btn btn-sm btn-default"><i class="fa fa-refresh"></i></a>
            </div>
        </div>
    </div>
</div>
<div class="row" style="margin-top: 10px;">
    <div class="col-xs-12">

            <table id="simple-table" class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th class="center">
                        <label class="pos-rel">
                            <input type="checkbox" class="ace">
                            <span class="lbl"></span>
                        </label>
                    </th>
                    <th>标题</th>
                    <th>活动时间</th>
                    <th>活动状态</th>
                    <th>操作</th>
                </tr>
                </thead>

                <tbody>
                <?php if(isset($items) && $items){ ?>
                    <?php foreach ($items as $key => $value) { ?>
                        <tr data-id="<?php echo $value->id;?>">
                            <td class="center">
                                <label class="pos-rel">
                                    <input type="checkbox" class="ace">
                                    <span class="lbl"></span>
                                </label>
                            </td>
                            <td>
                                <input type="text" name="title" value="<?= $value->title;?>" placeholder="活动标题">
                            </td>
                            <td>
                                <input type="text" name="begin_at" value="<?= date('Y-m-d H:i:s', $value->start_at);?>" placeholder="开始时间">
                                至
                                <input type="text" name="end_at" value="<?= date('Y-m-d H:i:s', $value->end_at);?>" placeholder="结束时间">
                            </td>
                            <td>
                                <select name="status">
                                    <option value="normal">正常</option>
                                    <option value="stop">停止</option>
                                </select>
                            </td>
                            <td>
                                <a class="btn btn-sm btn-success" role="btnSave" >
                                    保存
                                </a>
                                <a class="btn btn-sm btn-danger" role="btnDel">
                                    删除
                                </a>
                                <a class="btn btn-sm btn-primary" href="/admin/marketing/vote/candidates/<?php echo $value->id; ?>">
                                    管理被投项目
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                <?php }else{ ?>
                    <tr>
                        <td colspan="5">
                            <div class="empty" style="border: 1px solid #e0e0e0; line-height: 300px; width: 100%; text-align: center;">
                                未找到相关数据
                            </div>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
                <?php if(isset($pagination) && $pagination){ ?>
                    <tfoot>
                    <tr>
                        <td colspan="9" style="text-align: right;">
                            <?php echo isset($pagination) && $pagination ? htmlspecialchars_decode($pagination) : ''; ?>
                        </td>
                    </tr>
                    </tfoot>
                <?php } ?>
            </table>
    </div><!-- /.span -->
</div>

<?php
$script = <<<js
js;

\Asset::js($script, [], 'before-script', true);
\Asset::js(['jquery-tmpl/jquery.tmpl.min.js', 'jquery-tmpl/jquery.tmplPlus.min.js', 'modules/admin/marketing/vote/index.js'], [], 'js-files', false);

?>

<script type="text/x-jquery-tmpl" id="tr">
<tr data-id="0">
    <td class="center">
        <label class="pos-rel">
            <input type="checkbox" class="ace">
            <span class="lbl"></span>
        </label>
    </td>
    <td>
        <input type="text" name="title" value="" placeholder="活动标题">
    </td>
    <td>
        <input type="text" name="begin_at" value="" placeholder="开始时间">
        至
        <input type="text" name="end_at" value="" placeholder="结束时间">
    </td>
    <td>
        <select name="status">
            <option value="normal">正常</option>
            <option value="stop">停止</option>
        </select>
    </td>
    <td>
        <a class="btn btn-sm btn-success" role="btnSave">
            保存
        </a>
        <a class="btn btn-sm btn-danger" role="btnDel">
            删除
        </a>
    </td>
</tr>
</script>
