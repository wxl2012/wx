<link rel="stylesheet" type="text/css" href="/assets/css/wayde_callout.css">
<link href="/assets/third-party/icheck/skins/square/blue.css" rel="stylesheet">
<style type="text/css">
    .menu-panel{
        background-image: url(/assets/img/iphone4.png);
        width: 344px;
        height: 623px;
        padding: 138px 0px 0px 46px;
    }
</style>
<div class="row">
    <div class="col-md-4">
        <div class="menu-panel">
            <iframe src="/admin/mp/function/menus" id="menu-panel" width="255" height="364" scrolling="no" style="border: 0px;"></iframe>
        </div>
    </div>
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-12">
                <a id="btnAddMenuItem" class="btn btn-primary">添加菜单</a>
                <a id="btnPublish" class="btn btn-success">保存并发布</a>
                <a id="btnRemoveMenuItem" class="btn btn-danger">删除当前选中菜单项</a>
                <a id="btnCloseMenu" class="btn btn-warning">关闭自定义菜单</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="bs-callout bs-callout-info" style="overflow:hidden;">
                    <h4>当前操作菜单</h4>
                    <p>菜单名称：<span id="current_menu_name">菜单</span></p>
                    <p>菜单级别：<span id="current_menu_level">一级菜单</span></p>
                    <p>菜单动作：<span id="current_menu_action"></span></p>
                    <p>动作内容：<span id="current_menu_content"></span></p>
                </div>
            </div>
        </div>
        <div class="row" id="select-category" style="display: none;">
            <div class="col-md-12">
                <div class="bs-callout bs-callout-danger">
                    菜单动作：
                    <select id="category">
                        <option value="normal">常规操作</option>
                        <option value="news">回复图文</option>
                        <!--<option value="function">功能模块</option>
                        <option value="event">事件</option>
                        <option value="other">其它</option>-->
                    </select>
                    <select id="action">
                        <option>关键字</option>
                        <option>网址</option>
                    </select>
                    <a href='javascript:;' id="select-message" class="btn btn-sm btn-primary" style="display: none; margin-left: 10px;">选择素材</a>
                </div>
            </div>
        </div>
        <div class="row" id="content-input" style="display: none;">
            <div class="col-md-12">
                <div class="bs-callout bs-callout-success">
                    <span id="labelTip">关键字：</span>
                    <input type="text" id="value" action="click" style="width: 80%;" />

                    <table class="table">
                        <thead>
                        <tr>
                            <th>
                                选中
                            </th>
                            <th>
                                标题
                            </th>
                            <th>
                                同步时间
                            </th>
                        </tr>
                        </thead>
                        <tbody id="materials">
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" id="pagination"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="row" id="login-radio" style="display: none;">
            <div class="col-md-12">
                <div class="bs-callout bs-callout-warning">
                    <span>会员登录模式：</span>
                    <input type="radio" id="auto" name="autoLogin" value="auto"> <label for="auto"> 自动登录 </label>
                    <input type="radio" id="input" name="autoLogin" value="input"> <label for="input"> 输入登录 </label>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="process" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="text-align: center;">
        <i class="ace-icon fa fa-spinner fa-spin orange" style="background-color: none; font-size: 100pt !important;"></i>
        <h2 style="color:#fff;">菜单将于24小时内生效。如急需查看，请您重新关注公众帐户即可查看新菜单</h2>
        <h3 id="status_text" style="color:#fff;">正在保存菜单。。。</h3>
    </div>
</div>

<!--<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      ...
    </div>
  </div>
</div>-->

<script type="text/x-jquery-tmpl" id="tr">
<tr>
    <td><input type="radio" name="media_id" value="${thumb_media_id}"></td>
    <td>${title}</td>
    <td>${updated_at}</td>
</tr>
</script>


<?php

$token = \Session::get('access_token', '');
$account = \Session::get('WXAccount', false);
$script = <<<js
    var _access_token = '{$token}';
    var _account_id = {$account->id};
js;

\Asset::js($script, [], 'after-script', true);
\Asset::js(['tools.js', 'jquery-tmpl/jquery.tmpl.min.js', 'jquery-tmpl/jquery.tmplPlus.min.js', 'icheck/icheck.min.js', 'mp/menu/action.js', 'mp/menu/parent.js'], [], 'js-files', false);

?>