<?php
$this->load->view('web_public/header');
$this->load->view('web_public/nav');
?>
	<!-- content start -->
	<div class="admin-content">
		<div class="am-cf am-padding">
			<div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">个人资料</strong> / <small>Personal information</small></div>
		</div>

		<hr/>
		<div class="am-g">
			<div class="am-u-sm-12 am-u-md-4 am-u-md-push-8">
				<div class="am-panel am-panel-default">
					<div class="am-panel-bd">
						<div class="am-g">
							<div class="am-u-md-4">
								<img class="am-img-circle am-img-thumbnail" src="http://amui.qiniudn.com/bw-2014-06-19.jpg?imageView/1/w/1000/h/1000/q/80" alt=""/>
							</div>
							<div class="am-u-md-8">
								<p>你可以使用<a href="#">gravatar.com</a>提供的头像或者使用本地上传头像。 </p>
								<form class="am-form">
									<div class="am-form-group">
										<input type="file" id="user-pic">
										<p class="am-form-help">请选择要上传的文件...</p>
										<button type="button" class="am-btn am-btn-primary am-btn-xs">保存</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>

				<div class="am-panel am-panel-default">
					<div class="am-panel-bd">
						<div class="user-info">
							<p>等级信息</p>
							<div class="am-progress am-progress-sm">
								<div class="am-progress-bar" style="width: 60%"></div>
							</div>
							<p class="user-info-order">当前等级：<strong>LV8</strong> 活跃天数：<strong>587</strong> 距离下一级别：<strong>160</strong></p>
						</div>
						<div class="user-info">
							<p>信用信息</p>
							<div class="am-progress am-progress-sm">
								<div class="am-progress-bar am-progress-bar-success" style="width: 80%"></div>
							</div>
							<p class="user-info-order">信用等级：正常当前 信用积分：<strong>80</strong></p>
						</div>
					</div>
				</div>

			</div>

			<div class="am-u-sm-12 am-u-md-8 am-u-md-pull-4">
				<form class="am-form am-form-horizontal">
					<div class="am-form-group">
						<label for="user-name" class="am-u-sm-3 am-form-label">简历名称</label>
						<div class="am-u-sm-9">
							<input type="password" id="user-name" placeholder="简历名称">
							<small>简历名称仅用来区分您的不同简历，不在网站中显示!</small>
						</div>
					</div>
					<div class="am-form-group">
						<label for="user-name" class="am-u-sm-3 am-form-label">真实姓名</label>
						<div class="am-u-sm-9">
							<input type="password" id="user-name" placeholder="真实姓名">
							<small>输入你的名字，让我们记住你。</small>
						</div>
					</div>
					<div class="am-form-group">
						<label for="user-name" class="am-u-sm-3 am-form-label">性别</label>
						<div class="am-u-sm-9">
							<input type="password" id="user-name" placeholder="性别">
							<small>输入你的名字，让我们记住你。</small>
						</div>
					</div>
					<div class="am-form-group">
						<label for="user-name" class="am-u-sm-3 am-form-label">出生年份</label>
						<div class="am-u-sm-9">
							<input type="password" id="user-name" placeholder="出生年份">
							<small>出生年份</small>
						</div>
					</div>
					<div class="am-form-group">
						<label for="user-name" class="am-u-sm-3 am-form-label">现居住地</label>
						<div class="am-u-sm-9">
							<input type="password" id="user-name" placeholder="现居住地">
							<small>现居住地</small>
						</div>
					</div>
					<div class="am-form-group">
						<label for="user-name" class="am-u-sm-3 am-form-label">学历</label>
						<div class="am-u-sm-9">
							<input type="password" id="user-name" placeholder="学历">
							<small>学历</small>
						</div>
					</div>
					<div class="am-form-group">
						<label for="user-name" class="am-u-sm-3 am-form-label">身高</label>
						<div class="am-u-sm-9">
							<input type="password" id="user-name" placeholder="身高">
							<small>身高</small>
						</div>
					</div>
					<div class="am-form-group">
						<label for="user-name" class="am-u-sm-3 am-form-label">籍贯</label>
						<div class="am-u-sm-9">
							<input type="password" id="user-name" placeholder="籍贯">
							<small>籍贯</small>
						</div>
					</div>
					<div class="am-form-group">
						<label for="user-name" class="am-u-sm-3 am-form-label">婚姻状况</label>
						<div class="am-u-sm-9">
							<input type="password" id="user-name" placeholder="婚姻状况">
							<small>婚姻状况</small>
						</div>
					</div>
					<div class="am-form-group">
						<label for="user-name" class="am-u-sm-3 am-form-label">期望行业</label>
						<div class="am-u-sm-9">
							<input type="password" id="user-name" placeholder="期望行业">
							<small>期望行业</small>
						</div>
					</div>
					<div class="am-form-group">
						<label for="user-name" class="am-u-sm-3 am-form-label">工作地区</label>
						<div class="am-u-sm-9">
							<input type="password" id="user-name" placeholder="工作地区
							">
							<small>工作地区</small>
						</div>
					</div>
					<div class="am-form-group">
						<label for="user-name" class="am-u-sm-3 am-form-label">期望职位</label>
						<div class="am-u-sm-9">
							<input type="password" id="user-name" placeholder="期望职位">
							<small>期望职位</small>
						</div>
					</div>
					<div class="am-form-group">
						<label for="user-name" class="am-u-sm-3 am-form-label">工作性质</label>
						<div class="am-u-sm-9">
							<input type="password" id="user-name" placeholder="工作性质">
							<small>工作性质</small>
						</div>
					</div>
					<div class="am-form-group">
						<label for="user-email" class="am-u-sm-3 am-form-label">电子邮件</label>
						<div class="am-u-sm-9">
							<input type="email" id="user-email" placeholder="输入你的电子邮件">
							<small>邮箱你懂得...</small>
						</div>
					</div>

					<div class="am-form-group">
						<label for="user-phone" class="am-u-sm-3 am-form-label">手机</label>
						<div class="am-u-sm-9">
							<input type="email" id="user-phone" placeholder="手机号码">
						</div>
					</div>

					<div class="am-form-group">
						<label for="user-QQ" class="am-u-sm-3 am-form-label">QQ</label>
						<div class="am-u-sm-9">
							<input type="email" id="user-QQ" placeholder="输入你的QQ号码">
						</div>
					</div>

					<div class="am-form-group">
						<label for="user-weibo" class="am-u-sm-3 am-form-label">微博</label>
						<div class="am-u-sm-9">
							<input type="email" id="user-weibo" placeholder="输入你的微博">
						</div>
					</div>

					<div class="am-form-group">
						<label for="user-intro" class="am-u-sm-3 am-form-label">简介</label>
						<div class="am-u-sm-9">
							<textarea class="" rows="5" id="user-intro" placeholder="输入个人简介"></textarea>
							<small>250字以内写出你的一生...</small>
						</div>
					</div>

					<div class="am-form-group">
						<div class="am-u-sm-9 am-u-sm-push-3">
							<button type="button" class="am-btn am-btn-primary">保存修改</button>
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