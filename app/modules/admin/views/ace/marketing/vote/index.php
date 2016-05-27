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
                <a href="/admin/vote/save" class="btn btn-sm btn-default"><i class="fa fa-plus"></i></a>
                <!--<button type="button" class="btn btn-default"><i class="fa fa-file-excel-o"></i></button>-->
                <a href="javascript:;" id="btnSyn" class="btn btn-sm btn-default"><i class="fa fa-refresh"></i></a>
            </div>
        </div>
    </div>
</div>
<div class="row" style="margin-top: 10px;">
    <div class="col-xs-12">
        <?php if(isset($items) && $items){ ?>
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
                <?php foreach ($items as $key => $value) { ?>
                    <tr data-id="<?php echo $value->id;?>">
                        <td class="center">
                            <label class="pos-rel">
                                <input type="checkbox" class="ace">
                                <span class="lbl"></span>
                            </label>
                        </td>
                        <td>
                            <a href="/admin/marketing/vote/candidates/<?php echo $value->id; ?>">
                            <?php echo $value->title;?>
                            </a>
                        </td>
                        <td>
                            <?php echo date('Y-m-d H:i:s', $value->start_at);?>至
                            <?php echo date('Y-m-d H:i:s', $value->end_at);?>
                        </td>
                        <td><?php echo $value->status == 'NORMAL' ? '正常' : '停止';?></td>

                        <td>

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
        <?php }else{ ?>
            <div style="border: 1px solid #e0e0e0; line-height: 300px; width: 100%; text-align: center;">
                未找到相关数据
            </div>
        <?php } ?>
    </div><!-- /.span -->
</div>

<?php
$script = <<<js
js;

\Asset::js($script, [], 'before-script', true);
\Asset::js(['modules/admin/mp/material/index.js'], [], 'js-files', false);

?>