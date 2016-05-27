<?php 
	$seller = \Session::get('seller', false);
	if( ! $seller){
		return;
	}
	$ot = \Input::get('order_type', false) ? '&order_type=' . \Input::get('order_type') : '';
?>
<ul class="nav nav-list">
	<li<?php echo (isset($menu) && $menu == 'dashboard') || ! isset($menu) || ! $menu ? ' class="active"' : '' ?>>
		<a href="/admin">
			<i class="menu-icon fa fa-tachometer"></i>
			<span class="menu-text"> 系统总览 </span>
		</a>

		<b class="arrow"></b>
	</li>

	<li<?php echo isset($menu) && $menu == 'wxaccount' ? ' class="active"' : '' ?>>
		<a href="/admin/wxaccount/save/1">
			<i class="menu-icon fa fa-wechat"></i>
			<span class="menu-text"> 微信公众号设置 </span>
		</a>

		<b class="arrow"></b>
	</li>

	<?php if(\Session::get('WXAccount', false)) { ?>
	<li<?php echo isset($menu) && in_array($menu, array('wechat', 'wxmaterial', 'wechat-menu', 'auto-reply')) ? ' class="open active"' : '' ?>>
		<a href="#" class="dropdown-toggle">
			<i class="menu-icon fa fa-wechat"></i>
			<span class="menu-text">
				微信功能
			</span>

			<b class="arrow fa fa-angle-down"></b>
		</a>

		<b class="arrow"></b>

		<ul class="submenu">
			<li<?php echo isset($menu) && 'wxmaterial' == $menu ? ' class="active"' : '' ?>>
				<a href="/admin/mp/material">
					<i class="menu-icon fa fa-caret-right"></i>
					素材库
				</a>

				<b class="arrow"></b>
			</li>
			<li<?php echo isset($menu) && 'wechat-menu' == $menu ? ' class="active"' : '' ?>>
				<a href="/admin/mp/function/menu">
					<i class="menu-icon fa fa-caret-right"></i>
					自定义菜单
				</a>

				<b class="arrow"></b>
			</li>
			<li<?php echo isset($menu) && 'auto-reply' == $menu ? ' class="active"' : '' ?> style="display:none;">
				<a href="/admin/mp/function/reply">
					<i class="menu-icon fa fa-caret-right"></i>
					自动回复
				</a>

				<b class="arrow"></b>
			</li>
		</ul>
	</li>
	<?php } ?>

	<li<?php echo isset($menu) && in_array($menu, array('vote', 'wxmaterial', 'wechat-menu', 'auto-reply')) ? ' class="open active"' : '' ?>>
		<a href="javascript:;" class="dropdown-toggle">
			<i class="menu-icon fa fa-wechat"></i>
			<span class="menu-text">
				营销活动
			</span>

			<b class="arrow fa fa-angle-down"></b>
		</a>

		<b class="arrow"></b>

		<ul class="submenu">
			<li<?php echo isset($menu) && 'vote' == $menu ? ' class="active"' : '' ?>>
				<a href="/admin/marketing/vote">
					<i class="menu-icon fa fa-caret-right"></i>
					微信投票
				</a>

				<b class="arrow"></b>
			</li>
			<li<?php echo isset($menu) && 'wechat-menu' == $menu ? ' class="active"' : '' ?>>
				<a href="/admin/mp/marketing/menu">
					<i class="menu-icon fa fa-caret-right"></i>
					命运测算
				</a>

				<b class="arrow"></b>
			</li>
			<li<?php echo isset($menu) && 'auto-reply' == $menu ? ' class="active"' : '' ?> style="display:none;">
				<a href="/admin/mp/function/reply">
					<i class="menu-icon fa fa-caret-right"></i>
					微信价值测算
				</a>

				<b class="arrow"></b>
			</li>
		</ul>
	</li>
</ul><!-- /.nav-list -->
