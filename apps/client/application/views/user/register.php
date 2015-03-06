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
			<form class="am-form">
				<div class="am-g am-margin-top">
					<div class="am-u-sm-4 am-u-md-2 am-text-right">
						用户名
					</div>
					<div class="am-u-sm-8 am-u-md-4">
						<input type="text" class="am-input-sm">
					</div>
					<div class="am-hide-sm-only am-u-md-6">*必填，不可重复</div>
				</div>

				<div class="am-g am-margin-top">
					<div class="am-u-sm-4 am-u-md-2 am-text-right">
						邮箱
					</div>
					<div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
						<input type="text" class="am-input-sm">
					</div>
				</div>

				<div class="am-g am-margin-top">
					<div class="am-u-sm-4 am-u-md-2 am-text-right">
						密码
					</div>
					<div class="am-u-sm-8 am-u-md-4">
						<input type="text" class="am-input-sm">
					</div>
					<div class="am-hide-sm-only am-u-md-6">选填</div>
				</div>

				<div class="am-g am-margin-top">
					<div class="am-u-sm-4 am-u-md-2 am-text-right">
						确认密码
					</div>
					<div class="am-u-sm-8 am-u-md-4">
						<input type="text" class="am-input-sm">
					</div>
					<div class="am-u-sm-12 am-u-md-6">不填写则自动截取内容前255字符</div>
				</div>

				<!--<div class="am-g am-margin-top-sm">
					<div class="am-u-sm-12 am-u-md-2 am-text-right admin-form-text">
						内容描述
					</div>
					<div class="am-u-sm-12 am-u-md-10">
						<textarea rows="10" placeholder="请使用富文本编辑插件"></textarea>
					</div>
				</div>-->

			</form>
		</div>
	</div>
</div>
<!-- content end -->
<a class="am-icon-btn am-icon-th-list am-show-sm-only admin-menu" data-am-offcanvas="{target: '#admin-offcanvas'}"></a>
<?php
	$this->load->view('web_public/footer');
?>