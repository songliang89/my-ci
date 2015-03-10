<?php
	$this->load->view('web_public/header');
	$this->load->view('web_public/nav');
?>
<div class="am-container">
	<div class="am-g">
		<div class="am-cf am-padding">
			<div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">首页</strong> /用户注册 <small></small></div>
		</div>
		<div class="am-tab-panel">
			<form class="am-form" onsubmit="return false;">
				<div class="am-g am-margin-top">
					<div class="am-u-sm-4 am-u-md-2 am-text-right">
						用户名
					</div>
					<div class="am-u-sm-8 am-u-md-4 ">
						<input type="text" class="am-input-sm" name="user_name" id="user_name">
					</div>
					<div class="am-u-md-5" style="display: none;" id="user_name_tips"></div>
				</div>

				<div class="am-g am-margin-top">
					<div class="am-u-sm-4 am-u-md-2 am-text-right">
						邮箱
					</div>
					<div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
						<input type="text" class="am-input-sm" name="email" id="email">
					</div>
					<div class="am-u-md-5" style="display: none;" id="email_tips"></div>
				</div>

				<div class="am-g am-margin-top">
					<div class="am-u-sm-4 am-u-md-2 am-text-right">
						密码
					</div>
					<div class="am-u-sm-8 am-u-md-4">
						<input type="password" class="am-input-sm" name="password" id="password">
					</div>
					<div class="am-u-md-5" style="display: none;" id="password_tips"></div>
				</div>
				<div class="am-g am-margin-top">
					<div class="am-u-sm-4 am-u-md-2 am-text-right">
						确认密码
					</div>
					<div class="am-u-sm-8 am-u-md-4">
						<input type="password" class="am-input-sm" name="password2" id="password2">
					</div>
					<div class="am-u-md-5" style="display: none;" id="password2_tips"></div>
				</div>
				<div class="am-g am-margin-top">
					<div class="am-u-sm-4 am-u-md-2 am-text-right">
						验证码
					</div>
					<div class="am-u-sm-2 am-u-md-2 am-u-end col-end">
						<input type="text" class="am-input-sm" name="input_authcode" id="input_authcode">
					</div>
					<div class="am-u-sm-2 am-u-md-3 am-u-end col-end"  id="">
						<img onclick="change_auth_code()" src="<?php echo base_url('authcode');?>" alt="点击更换验证码" id="authcode">
						看不清,<a href="javascript:;;" title="点击更换验证码" onclick="change_auth_code()"> 换一换</a>
					</div>
					<div class="am-u-md-5" style="display: none;" id="authcode_tips"></div>
				</div>
				<div class="am-g am-margin-top am-margin-bottom">
					<div class="am-u-sm-2 am-u-sm-offset-2">
					<button type="button" class="am-btn am-btn-primary am-btn-block" id="submit_register">提交保存</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- content end -->
<a class="am-icon-btn am-icon-th-list am-show-sm-only admin-menu" data-am-offcanvas="{target: '#admin-offcanvas'}"></a>
<script src="<?php echo base_url('assets/js/jquery.md5.js');?>"></script>
<script src="<?php echo base_url('assets/js/public.js');?>"></script>
<script src="<?php echo base_url('assets/js/user/user.js');?>"></script>
<?php
	$this->load->view('web_public/footer');
?>