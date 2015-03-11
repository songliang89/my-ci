<?php
$this->load->view('web_public/header');
$this->load->view('web_public/nav');
?>
	<!-- content start -->
	<div class="admin-content">

	<div class="am-cf am-padding">
		<div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">表格</strong> / <small>Table</small></div>
	</div>

	<div class="am-g">
		<div class="am-u-sm-12 am-u-md-6">
			<div class="am-btn-toolbar">
				<div class="am-btn-group am-btn-group-xs">
					<button type="button" class="am-btn am-btn-default"><span class="am-icon-plus"></span> 新增</button>
					<button type="button" class="am-btn am-btn-default"><span class="am-icon-save"></span> 保存</button>
					<button type="button" class="am-btn am-btn-default"><span class="am-icon-archive"></span> 审核</button>
					<button type="button" class="am-btn am-btn-default"><span class="am-icon-trash-o"></span> 删除</button>
				</div>
			</div>
		</div>
		<div class="am-u-sm-12 am-u-md-3">
			<div class="am-form-group">
				<select data-am-selected="{btnSize: 'sm'}">
					<option value="option1">所有类别</option>
					<option value="option2">IT业界</option>
					<option value="option3">数码产品</option>
					<option value="option3">笔记本电脑</option>
					<option value="option3">平板电脑</option>
					<option value="option3">只能手机</option>
					<option value="option3">超极本</option>
				</select>
			</div>
		</div>
		<div class="am-u-sm-12 am-u-md-3">
			<div class="am-input-group am-input-group-sm">
				<input type="text" class="am-form-field">
          <span class="am-input-group-btn">
            <button class="am-btn am-btn-default" type="button">搜索</button>
          </span>
			</div>
		</div>
	</div>

	<div class="am-g">
	<div class="am-u-sm-12">
	<form class="am-form">
	<table class="am-table am-table-striped am-table-hover table-main">
	<thead>
	<tr>
		<th class="table-check">
			<input type="checkbox" name="" title="全选/反选" id="check_all"/>
		</th>
		<th class="table-title">地区</th>
		<th class="table-id">ID</th>
		<th class="table-type">排序</th>
		<th class="table-set">操作</th>
	</tr>
	</thead>
	<tbody>
		<?php
			if (!empty($data)){
		?>
				<?php
					foreach ($data as $key => $val) {
				?>
							<tr>
								<td><input id="parent_<?php echo $val["id"];?>" type="checkbox"  name="district_id[]" value="<?php echo $val["id"];?>" class="parent" /></td>
								<td><i class="am-icon-folder-o launch" style="cursor: pointer;" id="<?php echo $val["id"];?>" handle="launch"></i>  &nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;" ><?php echo $val["category_name"];?></a></td>
								<td><?php echo $val["id"];?></td>
								<td><?php echo $val["category_order"];?></td>
								<td>
									<div class="am-btn-toolbar">
										<div class="am-btn-group am-btn-group-xs">
											<button class="am-btn am-btn-default am-btn-xs am-text-secondary"><span class="am-icon-pencil-square-o"></span> 编辑</button>
											<button class="am-btn am-btn-default am-btn-xs am-hide-sm-only"><span class="am-icon-copy"></span> 复制</button>
											<button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-trash-o"></span> 删除</button>
										</div>
									</div>
								</td>
							</tr>
				<?php
					}
				?>
		<?php
			}
		?>
	</tbody>
	</table>
	<!--<div class="am-cf">
		共 15 条记录
		<div class="am-fr">
			<ul class="am-pagination">
				<li class="am-disabled"><a href="#">«</a></li>
				<li class="am-active"><a href="#">1</a></li>
				<li><a href="#">2</a></li>
				<li><a href="#">3</a></li>
				<li><a href="#">4</a></li>
				<li><a href="#">5</a></li>
				<li><a href="#">»</a></li>
			</ul>
		</div>
	</div>
	<hr />
	<p>注：.....</p>-->
	</form>
	</div>

	</div>
	</div>
	<!-- content end -->
<script src="<?php echo base_url("assets/js/category/category.js");?>"></script>
<?php
$this->load->view('web_public/footer');
?>