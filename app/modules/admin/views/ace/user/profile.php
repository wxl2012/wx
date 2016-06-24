<style>
    .value{
        font-size: 14pt;
        line-height: 32px;
    }
</style>
<div class="">
    <div id="user-profile-3" class="user-profile row">
        <div class="col-sm-offset-1 col-sm-10">

            <div class="space"></div>

            <form class="form-horizontal">
                <div class="tabbable">
                    <ul class="nav nav-tabs padding-16">
                        <li class="active">
                            <a data-toggle="tab" href="#basicPanel" aria-expanded="true">
                                <i class="green ace-icon fa fa-pencil-square-o bigger-125"></i>
                                基本信息
                            </a>
                        </li>

                        <li class="">
                            <a data-toggle="tab" href="#rolePanel" aria-expanded="false">
                                <i class="purple ace-icon fa fa-users bigger-125"></i>
                                角色信息
                            </a>
                        </li>

                        <li class="">
                            <a data-toggle="tab" href="#tradePanel" aria-expanded="false">
                                <i class="blue ace-icon fa fa-key bigger-125"></i>
                                交易数据
                            </a>
                        </li>

                        <li class="">
                            <a data-toggle="tab" href="#stockPanel" aria-expanded="false">
                                <i class="blue ace-icon fa fa-key bigger-125"></i>
                                库存数据
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content profile-edit-tab-content">
                        <div id="basicPanel" class="tab-pane active">
                            <h4 class="header blue bolder smaller">常规信息</h4>

                            <div class="row">
                                <div class="col-xs-12 col-sm-4">
                                    <label class="ace-file-input ace-file-multiple">
                                        <input type="file">
                                        <span class="ace-file-container hide-placeholder selected">
                                            <span class="ace-file-name large" data-title="用户头像">
                                                <img class="middle" style="width: 135px; height: 150px; background-image: url('/assets/admin/ace/avatars/profile-pic.jpg');">
                                                <i class=" ace-icon fa fa-picture-o file-image"></i>
                                            </span>
                                        </span>
                                        <a class="remove" href="javascript:;"><i class=" ace-icon fa fa-times"></i></a>
                                    </label>
                                </div>

                                <div class="vspace-12-sm"></div>

                                <div class="col-xs-12 col-sm-8">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label no-padding-right" for="form-field-username">用户名</label>

                                        <div class="col-sm-8">
                                            <div class="value"><?= $people->parent->username; ?></div>
                                        </div>
                                    </div>

                                    <div class="space-4"></div>

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label no-padding-right" for="form-field-first">真实姓名</label>

                                        <div class="col-sm-8">
                                            <div class="value"><?= "{$people->first_name}{$people->last_name}"; ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-date">出生日期</label>

                                <div class="col-sm-9">
                                    <div class="input-medium">
                                        <div class="value"><?= $people->birthday ? date('Y-m-d', $people->birthday) : '未设置'; ?></div>
                                    </div>
                                </div>
                            </div>

                            <div class="space-4"></div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right">性别</label>

                                <div class="col-sm-9">
                                    <div class="value"><?= $people->gender?></div>
                                </div>
                            </div>

                            <div class="space-4"></div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-phone">身份证号</label>

                                <div class="col-sm-9">
                                    <div class="value"><?= $people->identity ? $people->identity : '未设置'; ?></div>
                                </div>
                            </div>

                            <div class="space"></div>
                            <h4 class="header blue bolder smaller">身体特征</h4>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-phone">年龄</label>

                                <div class="col-sm-9">
                                    <div class="value"><?= $people->age ? $people->age : '未设置'; ?></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-phone">身高</label>

                                <div class="col-sm-9">
                                    <div class="value"><?= $people->height ? $people->height : '未设置'; ?></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-phone">体重</label>

                                <div class="col-sm-9">
                                    <div class="value"><?= $people->weight ? $people->weight : '未设置'; ?></div>
                                </div>
                            </div>

                            <div class="space"></div>
                            <h4 class="header blue bolder smaller">联系方式</h4>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-email">电子邮箱</label>

                                <div class="col-sm-9">
                                    <div class="value"><?= $people->email ? $people->email : '未设置'; ?></div>
                                </div>
                            </div>

                            <div class="space-4"></div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-website">个人网站</label>

                                <div class="col-sm-9">
                                    <div class="value"><?= $people->email ? $people->email : '未设置'; ?></div>
                                </div>
                            </div>

                            <div class="space-4"></div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-phone">联系电话</label>

                                <div class="col-sm-9">
                                    <div class="value"><?= $people->phone ? $people->phone : '未设置'; ?></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-phone">现居地</label>

                                <div class="col-sm-9">
                                    <div class="value">
                                        <?= $people->country ? $people->country->name : ''; ?>
                                        <?= $people->province ? $people->province->name : ''; ?>
                                        <?= $people->city ? $people->city->name : ''; ?>
                                        <?= $people->county ? $people->county->name : ''; ?>
                                        <?= $people->address ? $people->address : ''; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="space"></div>
                            <h4 class="header blue bolder smaller">社交帐户</h4>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-facebook">QQ</label>

                                <div class="col-sm-9">
                                    <div class="value"><?= $people->qq ? $people->qq : '未设置'; ?></div>
                                </div>
                            </div>

                            <div class="space-4"></div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-twitter">MSN</label>

                                <div class="col-sm-9">
                                    <div class="value"><?= $people->msn ? $people->msn : '未设置'; ?></div>
                                </div>
                            </div>

                            <div class="space-4"></div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-gplus">YY</label>

                                <div class="col-sm-9">
                                    <div class="value"><?= '未设置'; ?></div>
                                </div>
                            </div>
                        </div>

                        <div id="rolePanel" class="tab-pane">
                            <div class="space-10"></div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right" for="form-field-username">职员帐户</label>

                                <div class="col-sm-8">
                                    <div class="value"><?= isset($people->employees) && $people->employees ? count($people->employees) : 0; ?>个职员帐户</div>
                                </div>
                            </div>

                            <div class="space-8"></div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right" for="form-field-username">会员帐户</label>

                                <div class="col-sm-8">
                                    <div class="value"><?= isset($people->members) && $people->members ? count($people->members) : 0; ?>个会员帐户</div>
                                </div>
                            </div>

                        </div>

                        <div id="tradePanel" class="tab-pane">
                            <div class="space-10"></div>

                            <table>
                                <thead>
                                    <tr>
                                        <th>标识</th>
                                        <th>交易日期</th>
                                        <th>支出/收入</th>
                                        <th>交易类型</th>
                                        <th>交易金额</th>
                                        <th>交易描述</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($people->trades as $item){ ?>
                                        <tr>
                                            <td><?= $item->id; ?></td>
                                            <td><?= $item->created_at ? date('Y-m-d H:i:s', $item->created_at) : '-'; ?></td>
                                            <td><?= $item->method; ?></td>
                                            <td><?= $item->entity; ?></td>
                                            <td><?= $item->money; ?></td>
                                            <td><?= $item->balance; ?></td>
                                            <td><?= $item->summary; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>

                                <tfoot>

                                </tfoot>
                            </table>
                        </div>

                        <div id="stockPanel" class="tab-pane">
                            <div class="space-10"></div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-pass1">New Password</label>

                                <div class="col-sm-9">
                                    <input type="password" id="form-field-pass1">
                                </div>
                            </div>

                            <div class="space-4"></div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-pass2">Confirm Password</label>

                                <div class="col-sm-9">
                                    <input type="password" id="form-field-pass2">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="clearfix form-actions hide">
                    <div class="col-md-offset-3 col-md-9">
                        <button class="btn btn-info" type="button">
                            <i class="ace-icon fa fa-check bigger-110"></i>
                            Save
                        </button>

                        &nbsp; &nbsp;
                        <button class="btn" type="reset">
                            <i class="ace-icon fa fa-undo bigger-110"></i>
                            Reset
                        </button>
                    </div>
                </div>
            </form>
        </div><!-- /.span -->
    </div><!-- /.user-profile -->
</div>