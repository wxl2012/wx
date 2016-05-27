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
                <a id="btnAdd" class="btn btn-sm btn-default"><i class="fa fa-plus"></i></a>
                <!--<button type="button" class="btn btn-default"><i class="fa fa-file-excel-o"></i></button>-->
                <a href="javascript:window.location.reload();" id="btnSyn" class="btn btn-sm btn-default"><i class="fa fa-refresh"></i></a>
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
                <th>投票编号</th>
                <th>投票关键字</th>
                <th>名字</th>
                <th>当前票数</th>
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
                        <td><input type="text" value="<?php echo $value->no;?>" role="no"></td>
                        <td><input type="text" value="<?php echo $value->keyword;?>" role="keyword"></td>
                        <td><input type="text" value="<?php echo $value->title;?>" role="title"></td>
                        <td><input type="text" value="<?php echo $value->total_gain;?>" role="total_gain"></td>
                        <td><a role="btnSave" class="btn btn-sm btn-primary">保存</a></td>
                    </tr>
                <?php } ?>
            <?php }else{ ?>
                <tr>
                    <td colspan="6">
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
                    <td colspan="6" style="text-align: right;">
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
    var marketing_id = {$marketing->id};
js;

\Asset::js($script, [], 'before-script', true);
\Asset::js(['tools.js', 'jquery-tmpl/jquery.tmpl.min.js', 'jquery-tmpl/jquery.tmplPlus.min.js', 'modules/admin/marketing/vote/candidates.js'], [], 'js-files', false);

?>

<script type="text/x-jquery-tmpl" id="tr">
<tr data-id="0">
    <td class="center">
        <label class="pos-rel">
            <input type="checkbox" class="ace">
            <span class="lbl"></span>
        </label>
    </td>
    <td><input type="text" value="" role="no"></td>
    <td><input type="text" value="" role="keyword"></td>
    <td><input type="text" value="" role="title"></td>
    <td><input type="text" value="0" role="total_gain"></td>
    <td><a role="btnSave" class="btn btn-sm btn-primary">保存</a></td>
</tr>
</script>
