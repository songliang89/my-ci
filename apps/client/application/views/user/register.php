<?php
	$this->load->view('include/header');
?>

<div class="navbar navbar-inverse">
	<div class="navbar-inner">
		<a class="brand" href="#">Title</a>
		<ul class="nav">
			<li class="active"><a href="#">首页</a></li>
			<li><a href="#">Link</a></li>
			<li><a href="#">Link</a></li>
		</ul>
	</div>
</div>

<div class="container">
	<div class="row">
		<h3 class="page-header">用户注册</h3>
		<form class="form-horizontal well" onsubmit="return false;">
			<div class="control-group">
				<label for="user_name" class="control-label">用户名</label>
				<div class="controls">
					<input type="text" class="form-control" id="user_name" placeholder="用户名">
					<span class="help-inline" id="user_name_msg" style="display: none;"></span>
				</div>
			</div>
			<div class="control-group">
				<label for="email" class="control-label">邮箱</label>
				<div class="controls">
					<input type="email" class="form-control" id="email" placeholder="邮箱">
					<span class="help-inline" id="email_msg" style="display: none;"></span>
				</div>
			</div>
			<div class="control-group">
				<label for="password" class="control-label">密码</label>
				<div class="controls">
					<input type="password" class="form-control" id="password" placeholder="密码">
					<span class="help-inline" id="password_msg" style="display: none;"></span>
				</div>
			</div>
			<div class="control-group">
				<label for="again_password" class="control-label">确认密码</label>
				<div class="controls">
					<input type="password" class="form-control" id="again_password" placeholder="确认密码">
					<span class="help-inline" id="again_password_msg" style="display: none;"></span>
				</div>
			</div>
			<!--<div class="checkbox">
				<label>
					<input type="checkbox"> Check me out
				</label>
			</div>-->
			<div class="control-group">
				<div class="controls">
					<button type="submit" class="btn btn-primary">注册</button>
				</div>
			</div>
		</form>
	</div>
</div>
<script src="<?php echo base_url('assets/js/user/user.js');?>"></script>
<?php
	$this->load->view('include/footer');
?>
