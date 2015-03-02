<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="">

	<title>Rbac Demo</title>

	<link href="<?php echo base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/css/bootstrap-responsive.min.css') ?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/css/font-awesome.css') ?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/css/custom.css') ?>" rel="stylesheet">

	<script src="<?php echo base_url('assets/js/jquery.min.js')?>"></script>
	<script src="<?php echo base_url('assets/js/jquery-ui.min.js')?>"></script>
	<script src="<?php echo base_url('assets/js/lodash.min.js')?>"></script>
	<script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/custom.js') ?>"></script>
</head>
<body>
	<div class="container">
		<div class="row">
			<form action="" method="get">
				<div class="form-group">
					<label for="exampleInputEmail1">关键词</label>
					<input name="s" type="email" class="form-control" id="exampleInputEmail1" placeholder="关键词">
				</div>
				<div class="form-group">
					<label>频道</label>
					<select class="form-control" name="c">
						<option value="youhui">优惠</option>
						<option value="haitao">海淘</option>
						<option value="faxian">发现</option>
						<option value="jingyan">经验</option>
						<option value="shaiwu">晒物</option>
						<option value="news">咨询</option>
					</select>
				</div>
				<div class="form-group">
					<label>时间范围</label>
					<select class="form-control" name="t">
						<option value="1">一天内</option>
						<option value="2">三天内</option>
						<option value="3">一周内</option>
						<option value="4">一个月内</option>
						<option value="5">一年内</option>
					</select>
				</div>
				<div class="form-group">
					<label>排序</label>
					<select class="form-control" name="o">
						<option value="desc">降序</option>
						<option value="asc">升序</option>
				</select>
				</div>
				<button type="submit" class="btn btn-default">查询</button>
			</form>
		</div>
	</div>
</body>
</html>