<div id="signup-box" class="signup-box widget-box no-border">
	<div class="widget-body">
		<div class="widget-main">
			<h4 class="header green lighter bigger">
				<i class="ace-icon fa fa-users blue"></i>
				注册新用户
			</h4>

			<div class="space-6"></div>
			<p> 请填写以下注册信息: </p>

			<form>
				<fieldset>
					<label class="block clearfix">
						<span class="block input-icon input-icon-right">
							<select class="form-control">
								<option>手机注册</option>
								<option>邮箱注册</option>
							</select>
						</span>
					</label>
					<label class="block clearfix" style="display:none;">
						<span class="block input-icon input-icon-right">
							<input type="email" class="form-control" placeholder="安全邮箱" />
							<i class="ace-icon fa fa-envelope"></i>
						</span>
					</label>

					<label class="block clearfix">
						<span class="block input-icon input-icon-right">
							<input type="text" class="form-control" placeholder="手机号码" />
							<i class="ace-icon fa fa-mobile" style="font-size: 2em"></i>
						</span>
					</label>

					<!--<label class="block clearfix">
						<span class="block input-icon input-icon-right">
							<input type="text" class="form-control" placeholder="请输入一个用户名" />
							<i class="ace-icon fa fa-user"></i>
						</span>
					</label>-->

					<label class="block clearfix">
						<span class="block input-icon input-icon-right">
							<input type="password" class="form-control" placeholder="请输入密码" />
							<i class="ace-icon fa fa-lock"></i>
						</span>
					</label>

					<label class="block clearfix">
						<span class="block input-icon input-icon-right">
							<input type="password" class="form-control" placeholder="确认密码" />
							<i class="ace-icon fa fa-retweet"></i>
						</span>
					</label>

					<label class="block">
						<input type="checkbox" class="ace" />
						<span class="lbl">
							我同意
							<a href="#"><?php echo isset($GLOBAL_OPTIONS['site_admin_name']) ? $GLOBAL_OPTIONS['site_admin_name'] : ''; ?></a>
						</span>
					</label>

					<div class="space-24"></div>

					<div class="clearfix">
						<button type="reset" class="width-30 pull-left btn btn-sm">
							<i class="ace-icon fa fa-refresh"></i>
							<span class="bigger-110">重置</span>
						</button>

						<button type="button" class="width-65 pull-right btn btn-sm btn-success">
							<span class="bigger-110">注册</span>

							<i class="ace-icon fa fa-arrow-right icon-on-right"></i>
						</button>
					</div>
				</fieldset>
			</form>
		</div>

		<div class="toolbar center">
			<a href="#" data-target="#login-box" class="back-to-login-link">
				<i class="ace-icon fa fa-arrow-left"></i>
				返回登录页
			</a>
		</div>
	</div><!-- /.widget-body -->
</div><!-- /.signup-box -->