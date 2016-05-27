<?php $people = \Session::get('current_people', false);?>
<li class="light-blue">
	<a data-toggle="dropdown" href="#" class="dropdown-toggle">
		<img class="nav-user-photo" src="<?php echo \Auth::check() && $people && $people->photo ? $people->photo : '/assets/admin/ace/avatars/user.jpg'?>" alt="Jason's Photo" />
		<span class="user-info">
			<small>欢迎,</small>
			<?php 
				$display_name = '';
				if(\Auth::check()){
					if($people && $people->first_name){
						$display_name = $people->first_name . ($people->gender == '男' ? '先生' : '女士');
					}else if($people && $people->nickname){
						$display_name = $people->nickname;
					}else{
						$display_name = \Auth::get_screen_name();
					}
				}
				echo $display_name;
			?>
		</span>

		<i class="ace-icon fa fa-caret-down"></i>
	</a>

	<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
		<li>
			<a href="#">
				<i class="ace-icon fa fa-cog"></i>
				设置
			</a>
		</li>

		<li>
			<a href="/admin/user/change_pwd">
				<i class="ace-icon fa fa-key"></i>
				修改密码
			</a>
		</li>

		<li>
			<a href="#">
				<i class="ace-icon fa fa-user"></i>
				个人资讯
			</a>
		</li>

		<li class="divider"></li>

		<li>
			<a href="/admin/logout">
				<i class="ace-icon fa fa-power-off"></i>
				安全退出
			</a>
		</li>
	</ul>
</li>