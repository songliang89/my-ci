<?php
if(!empty($list)) {
?>
<div class="container">

	<div class="row">
		<h1 class="page-header">用户列表</h1>
		<table class="table table-bordered table-striped">
			<tr>
				<th>用户id</th>
				<th>用户名</th>
				<th>角色</th>
				<th>操作</th>
			</tr>
			<?php
				foreach ($list as $key => $row) {
			?>
				<tr>
					<td><?php echo $row['user_id'];?></td>
					<td><?php echo $row['user_name'];?></td>
					<td><?php echo $row['role_name'];?></td>
					<td>编辑</td>
				</tr>
			<?php }?>
		</table>
	</div>

</div>
<?php
} else {
	?>
	<div class="message">
		<?php echo "暂无数据";?>
	</div>
<?php
}
?>