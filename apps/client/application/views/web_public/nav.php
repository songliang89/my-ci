<header class="am-topbar admin-header">
	<div class="am-topbar-brand">
		<strong>Amaze UI</strong> <small>后台管理模板</small>
	</div>
	<button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only" data-am-collapse="{target: '#topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>

	<div class="am-collapse am-topbar-collapse" id="topbar-collapse">
		<ul class="am-nav am-nav-pills am-topbar-nav am-topbar-right admin-header-list">
			<li id="login"><a href="/login?url=<?php echo urlencode(current_url());?>" target="_self"> 登录 </a></li>
			<li id="register"><a href="/register" target="_self"> 注册 </a></li>
			<li style="display: none;" id="user_msg"><a href="javascript:;"><span class="am-icon-envelope-o"></span> 收件箱 <span class="am-badge am-badge-warning">5</span></a></li>
			<li class="am-dropdown" data-am-dropdown style="display: none;" id="userinfo">
				<a class="am-dropdown-toggle" data-am-dropdown-toggle href="javascript:;">
					<span class="am-icon-users"></span> <b id="username"></b> <span class="am-icon-caret-down"></span>
				</a>
				<ul class="am-dropdown-content">
					<li><a href="#"><span class="am-icon-user"></span> 资料</a></li>
					<li><a href="#"><span class="am-icon-cog"></span> 设置</a></li>
					<li><a href="#"><span class="am-icon-power-off"></span> 退出</a></li>
				</ul>
			</li>
			<li id="logout" style="display: none;"><a href="/logout?url=<?php echo urlencode(current_url());?>" > 退出 </a></li>
			<li class="am-hide-sm-only"><a href="javascript:;" id="admin-fullscreen"><span class="am-icon-arrows-alt"></span> <span class="admin-fullText">开启全屏</span></a></li>
		</ul>
	</div>
</header>