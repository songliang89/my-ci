<?php
$this->load->view('web_public/header');
$this->load->view('web_public/nav');
?>
<?php
	$category_name = isset($info['category_name']) && ""!=$info['category_name'] ? $info['category_name'] : "";
	$category_order = isset($info['category_order']) && ""!=$info['category_order'] ? (int)$info['category_order'] : 0;
	$parent_id = isset($info['parentid']) && ""!=$info['parentid'] ? (int)$info['parentid'] : 0;
	$cate_id = isset($info['id']) && ""!=$info['id'] ? (int)$info['id'] : 0;
?>
	<div class="am-container">
		<div class="am-g">
			<div class="am-cf am-padding">
				<div class="am-fl am-cf"><a href="<?php echo base_url("district")?>"><strong class="am-text-primary am-text-lg">地区列表</strong></a> /修改地区 <small></small></div>
			</div>
			<div class="am-tab-panel">
				<form class="am-form" action="" method="post">
					<input type="hidden" value="<?php echo $cate_id;?>" name="id">
					<div class="am-g am-margin-top">
						<div class="am-u-sm-4 am-u-md-2 am-text-right">
							所属分类
						</div>
						<div class="am-u-sm-8 am-u-md-4 ">
							<select name="parentid">
								<option value="0" <?php if($parent_id == 0){?>selected <?php }?> >顶级分类</option>
								<?php
									foreach($topList as $key => $val) {
								?>
								<option value="<?php echo $val["id"];?>" <?php if($parent_id == $val["id"]){?>selected <?php }?> ><?php echo htmlspecialchars($val['category_name']);?></option>
								<?php }?>
							</select>
						</div>
						<div class="am-u-md-5" style="display: none;" id="login_user_name_tips"></div>
					</div>
					<div class="am-g am-margin-top">
						<div class="am-u-sm-4 am-u-md-2 am-text-right">
							分类名
						</div>
						<div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
							<input type="text" class="am-input-sm" name="category_name" value="<?php echo htmlspecialchars($category_name);?>">
						</div>
						<div class="am-u-md-5" style="display: none;"></div>
					</div>
					<div class="am-g am-margin-top">
						<div class="am-u-sm-4 am-u-md-2 am-text-right">
							排序
						</div>
						<div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
							<input type="text" class="am-input-sm" name="category_order" value="<?php echo htmlspecialchars($category_order);?>">
						</div>
						<div class="am-u-md-5" style="display: none;" ></div>
					</div>

					<div class="am-g am-margin-top am-margin-bottom">
						<div class="am-u-sm-2 am-u-sm-offset-2">
							<button type="submit" class="am-btn am-btn-primary am-btn-block">保存</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- content end -->
	<a class="am-icon-btn am-icon-th-list am-show-sm-only admin-menu" data-am-offcanvas="{target: '#admin-offcanvas'}"></a>
<?php
$this->load->view('web_public/footer');
?>