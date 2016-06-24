<!-- #section:basics/navbar.layout -->
<div id="navbar" class="navbar navbar-default">
	<script type="text/javascript">
		try{ace.settings.check('navbar' , 'fixed')}catch(e){}
	</script>

	<div class="navbar-container" id="navbar-container">
		<!-- #section:basics/sidebar.mobile.toggle -->
		<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
			<span class="sr-only">Toggle sidebar</span>

			<span class="icon-bar"></span>

			<span class="icon-bar"></span>

			<span class="icon-bar"></span>
		</button>

		<!-- /section:basics/sidebar.mobile.toggle -->
		<div class="navbar-header pull-left">
			<!-- #section:basics/navbar.layout.brand -->
			<a href="#" class="navbar-brand">
				<small>
					<i class="fa fa-leaf"></i>
					<?php echo isset($GLOBAL_OPTIONS['site_admin_name']) ? $GLOBAL_OPTIONS['site_admin_name'] : '后台管理';?>
				</small>
			</a>

			<!-- /section:basics/navbar.layout.brand -->

			<!-- #section:basics/navbar.toggle -->

			<!-- /section:basics/navbar.toggle -->
		</div>

		<!-- #section:basics/navbar.dropdown -->
		<div class="navbar-buttons navbar-header pull-right" role="navigation">
			<ul class="nav ace-nav">
				<!--<li class="grey">
					<a data-toggle="dropdown" class="dropdown-toggle" href="#">
						<i class="ace-icon fa fa-tasks"></i>
						<span class="badge badge-grey">4</span>
					</a>

					<ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
						<li class="dropdown-header">
							<i class="ace-icon fa fa-check"></i>
							4 Tasks to complete
						</li>

						<li class="dropdown-content">
							<ul class="dropdown-menu dropdown-navbar">
								<li>
									<a href="#">
										<div class="clearfix">
											<span class="pull-left">Software Update</span>
											<span class="pull-right">65%</span>
										</div>

										<div class="progress progress-mini">
											<div style="width:65%" class="progress-bar"></div>
										</div>
									</a>
								</li>

								<li>
									<a href="#">
										<div class="clearfix">
											<span class="pull-left">Hardware Upgrade</span>
											<span class="pull-right">35%</span>
										</div>

										<div class="progress progress-mini">
											<div style="width:35%" class="progress-bar progress-bar-danger"></div>
										</div>
									</a>
								</li>

								<li>
									<a href="#">
										<div class="clearfix">
											<span class="pull-left">Unit Testing</span>
											<span class="pull-right">15%</span>
										</div>

										<div class="progress progress-mini">
											<div style="width:15%" class="progress-bar progress-bar-warning"></div>
										</div>
									</a>
								</li>

								<li>
									<a href="#">
										<div class="clearfix">
											<span class="pull-left">Bug Fixes</span>
											<span class="pull-right">90%</span>
										</div>

										<div class="progress progress-mini progress-striped active">
											<div style="width:90%" class="progress-bar progress-bar-success"></div>
										</div>
									</a>
								</li>
							</ul>
						</li>

						<li class="dropdown-footer">
							<a href="#">
								See tasks with details
								<i class="ace-icon fa fa-arrow-right"></i>
							</a>
						</li>
					</ul>
				</li>-->

				<li class="purple">
					<a data-toggle="dropdown" class="dropdown-toggle" href="#">
						<i class="ace-icon fa fa-bell<?php echo isset($notices_messages) && $notices_messages ? " icon-animated-bell" : ''?>"></i>
						<?php if(isset($notices_messages) && $notices_messages){ ?>
						<span class="badge badge-important"><?php echo count($notices_messages);?></span>
						<?php } ?>
					</a>

					<ul class="dropdown-menu-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
						<li class="dropdown-header">
							<i class="ace-icon fa fa-exclamation-triangle"></i>
							<?php echo isset($notices_messages) && $notices_messages ? count($notices_messages) . " 项通知" : '暂未收到任何通知'?>
						</li>

						
						<?php if(isset($notices_messages) && $notices_messages){ ?>
						<li class="dropdown-content">
							<ul class="dropdown-menu dropdown-navbar navbar-pink">
								<?php foreach ($notices_messages as $key => $value) { ?>
								<li>
									<a href="#">
										<div class="clearfix">
											<span class="pull-left">
												<i class="btn btn-xs no-hover btn-<?php echo $value->btn_color; ?> fa fa-<?php echo $value->icon; ?>"></i>
												<?php echo $value->title; ?>
											</span>
											<?php if($value->num > 1){ ?>
											<span class="pull-right badge badge-<?php echo $value->num_color; ?>">+<?php echo $value->num; ?></span>
											<?php } ?>
											
										</div>
									</a>
								</li>
								<?php } ?>
							</ul>
						</li>
						<?php } ?>

						<li class="dropdown-footer">
							<a href="#">
								查看所有通知
								<i class="ace-icon fa fa-arrow-right"></i>
							</a>
						</li>
					</ul>
				</li>

				<li class="green">
					<a data-toggle="dropdown" class="dropdown-toggle" href="#">
						<i class="ace-icon fa fa-envelope<?php echo isset($news_messages) && $news_messages ? " icon-animated-vertical" : ''?>"></i>
						<?php if(isset($news_messages) && $news_messages){ ?>
						<span class="badge badge-success"><?php echo count($news_messages);?></span>
						<?php } ?>
					</a>

					<ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
						<li class="dropdown-header">
							<i class="ace-icon fa fa-envelope-o"></i>
							<?php echo isset($news_messages) && $news_messages ? count($news_messages) . " 条消息" : '您没有未读消息'?>
						</li>
						<?php if(isset($news_messages) && $news_messages){ ?>
						<li class="dropdown-content">
							<ul class="dropdown-menu dropdown-navbar">
								<?php foreach ($news_messages as $key => $value) { ?>
								<li>
									<a href="#" class="clearfix">
										<img src="<?php echo $value->from->people->photo;?>" class="msg-photo" alt="<?php echo $value->from->people->nickname;?> Avatar" />
										<span class="msg-body">
											<span class="msg-title">
												<span class="blue"><?php echo $value->from->people->nickname;?>:</span>
												<?php echo \Str::truncate($value->body, 0, 21, '...'); ?>
											</span>

											<span class="msg-time">
												<i class="ace-icon fa fa-clock-o"></i>
												<span><?php echo \Date::time_ago($value->created_at); ?></span>
											</span>
										</span>
									</a>
								</li>
								<?php } ?>
							</ul>
						</li>
						<?php } ?>

						<li class="dropdown-footer">
							<a href="#">
								查看所有消息
								<i class="ace-icon fa fa-arrow-right"></i>
							</a>
						</li>
					</ul>
				</li>
						

				<!-- #section:basics/navbar.user_menu -->
				<?php echo render('ace/public/nav_user_menu'); ?>
				<!-- /section:basics/navbar.user_menu -->
			</ul>
		</div>

		<!-- /section:basics/navbar.dropdown -->
	</div><!-- /.navbar-container -->
</div>

<!-- /section:basics/navbar.layout -->