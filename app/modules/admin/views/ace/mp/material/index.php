<div class="row">
    <div class="col-xs-6">
        <select id="account_id" name="account_id">
            <option></option>
        </select>
    </div>
    <div class="col-xs-6">
        <div class="clearfix" style="text-align: right; padding-right: 12px;">
            <div class="btn-group" role="group" aria-label="First group">
                <!--<button type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
                <a href="/admin/vote/save" class="btn btn-default"><i class="fa fa-plus"></i></a>
                <button type="button" class="btn btn-default"><i class="fa fa-file-excel-o"></i></button>-->
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
                    <th class="hide">作者</th>
                    <th class="hide">描述</th>
                    <th>创建时间</th>
                    <th>更新时间</th>
                    <th>最后同步时间</th>
                    <th>操作</th>
                </tr>
                </thead>

                <tbody>
                <?php foreach ($items as $key => $value) { ?>
                    <tr data-id="<?php echo $value->thumb_media_id;?>" <?php echo $value->menu_keyword ? 'style="color: #428bca"' : '';?>>
                        <td class="center">
                            <label class="pos-rel">
                                <input type="checkbox" class="ace">
                                <span class="lbl"></span>
                            </label>
                        </td>
                        <td><?php echo $value->title;?></td>
                        <td class="hide"><?php echo $value->author;?></td>
                        <td class="hide"><?php echo $value->digest;?></td>
                        <td><?php echo date('Y-m-d H:i:s', $value->create_time);?></td>
                        <td><?php echo date('Y-m-d H:i:s', $value->update_time);?></td>
                        <td><?php echo date('Y-m-d H:i:s', $value->updated_at);?></td>

                        <td>
                            <select>
                                <option>请选择</option>
                                <?php $labels = ['', '一', '二', '三', '四', '五'];?>
                                <?php foreach (['a', 'b', 'c'] as $keyword){ ?>
                                    <optgroup label="一级<?php echo strtoupper($keyword); ?>组">
                                        <?php for ($i = 1; $i < 6; $i ++){ ?>
                                            <option value="<?php echo "{$keyword}{$i}"?>"<?php echo "{$keyword}{$i}" == $value->menu_keyword ? ' selected' : ''; ?>><?php echo strtoupper($keyword);?>组第<?php echo $labels[$i];?>项子菜单</option>
                                        <?php } ?>
                                    </optgroup>
                                <?php } ?>
                            </select>
                            <!--<div class="hidden-sm hidden-xs btn-group">
                                <a href="/admin/vote/save/<?php echo $value->thumb_media_id; ?>" class="btn btn-xs btn-info" title="编辑">
                                    <i class="ace-icon fa fa-pencil bigger-120"></i>
                                </a>

                                <a class="btn btn-xs btn-danger" title="删除" data-toggle="modal" data-target="#confirmModal">
                                    <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                </a>

                                <a class="btn btn-xs btn-success" title="票数统计" href="/admin/vote/report/<?php echo $value->thumb_media_id; ?>">
                                    <i class="ace-icon fa fa-bar-chart-o bigger-120"></i>
                                </a>

                                <a class="btn btn-xs btn-success" title="查看参与记录" href="/admin/vote/records/<?php echo $value->thumb_media_id; ?>">
                                    <i class="ace-icon fa fa-paw bigger-120"></i>
                                </a>

                                <a class="btn btn-xs btn-info" title="查看未审核的报名项" href="/admin/vote/wait/<?php echo $value->thumb_media_id; ?>">
                                    <i class="ace-icon fa fa-filter bigger-120"></i>
                                </a>
                            </div>

                            <div class="hidden-md hidden-lg">
                                <div class="inline pos-rel">
                                    <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown" data-position="auto">
                                        <i class="ace-icon fa fa-cog icon-only bigger-110"></i>
                                    </button>

                                    <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                        <li>
                                            <a href="#" class="tooltip-info" data-rel="tooltip" title="" data-original-title="View">
											<span class="blue">
												<i class="ace-icon fa fa-qrcode bigger-120"></i>
											</span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#" class="tooltip-success" data-rel="tooltip" title="" data-original-title="Edit">
											<span class="green">
												<i class="ace-icon fa fa-bar-chart bigger-120"></i>
											</span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#" class="tooltip-error" data-rel="tooltip" title="" data-original-title="Delete">
											<span class="red">
												<i class="ace-icon fa fa-pencil bigger-120"></i>
											</span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#" class="tooltip-error" data-rel="tooltip" title="" data-original-title="Delete">
											<span class="red">
												<i class="ace-icon fa fa-trash-o bigger-120"></i>
											</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>-->
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