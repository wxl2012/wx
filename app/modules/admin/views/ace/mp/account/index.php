<div class="row">
    <div clsss="col-xs-12">
        <div class="clearfix" style="text-align: right; padding-right: 12px;">
            <div class="btn-group" role="group" aria-label="First group">
                <button type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
                <button type="button" class="btn btn-default"><i class="fa fa-plus"></i></button>
                <button type="button" class="btn btn-default"><i class="fa fa-file-excel-o"></i></button>
                <button type="button" class="btn btn-default"><i class="fa fa-refresh"></i></button>
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
                    <th>Open ID</th>
                    <th>公众号名称</th>
                    <th>公众号类型</th>
                    <th>用户名</th>
                    <th>密码</th>
                    <?php if(Auth::has_access('admin.wxaccount[show_seller]')){ ?>
                        <th>所属商户</th>
                    <?php } ?>
                    <th class="hidden-480">公众号接入token</th>
                    <th class="hidden-480">认证状态</th>
                    <th>操作</th>
                </tr>
                </thead>

                <tbody>
                <?php foreach ($items as $key => $value) { ?>
                    <tr>
                        <td class="center">
                            <label class="pos-rel">
                                <input type="checkbox" class="ace">
                                <span class="lbl"></span>
                            </label>
                        </td>
                        <td><?php echo $value->open_id; ?></td>
                        <td><?php echo $value->nickname; ?></td>
                        <td class="hidden-480"><?php echo $value->type ? \Model_WXAccount::$_maps['type'][$value->type] : ''; ?></td>
                        <td><?php echo $value->username; ?></td>
                        <td><?php echo $value->password; ?></td>
                        <?php if(Auth::has_access('admin.wxaccount[show_seller]')){ ?>
                            <td>
                                <?php
                                if($value->seller){
                                    echo $value->seller->short_name ? $value->seller->short_name : $value->seller->name;
                                }else{
                                    echo '-';
                                }
                                ?>
                            </td>
                        <?php } ?>
                        <td><?php echo $value->token; ?></td>
                        <td class="hidden-480">
						<span class="label label-sm label-<?php echo \Model_WXAccount::$_maps['status_label'][$value->auth_status]; ?>">
							<?php echo \Model_WXAccount::$_maps['status'][$value->auth_status]; ?>
						</span>
                        </td>

                        <td>
                            <div class="hidden-sm hidden-xs btn-group">
                                <a class="btn btn-xs btn-info" title="编辑" href="/admin/wxaccount/save/<?php echo $value->id;?>">
                                    <i class="ace-icon fa fa-pencil bigger-120"></i>
                                </a>

                                <button class="btn btn-xs btn-danger" title="删除">
                                    <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                </button>

                                <a class="btn btn-xs btn-primary" title="带参数二维码管理" href="/admin/wxaccount/param_qrcode/<?php echo $value->id; ?>">
                                    <i class="ace-icon fa fa-qrcode bigger-120"></i>
                                </a>

                                <a class="btn btn-xs btn-success" title="查看推广数据" href="/admin/wxaccount/records">
                                    <i class="ace-icon fa fa-bar-chart bigger-120"></i>
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
                            </div>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        <?php }else{ ?>
            <div style="border: 1px solid #e0e0e0; line-height: 300px; width: 100%; text-align: center;">
                未找到相关数据
            </div>
        <?php } ?>
    </div><!-- /.span -->
</div>