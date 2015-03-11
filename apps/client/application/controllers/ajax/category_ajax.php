<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by linzl
 * User: linzl<linzhenlong@smzdm.com>
 * Date: 15/3/11
 * Time: 上午11:14
 */
class Category_ajax extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('category/district_model');
	}

	/**
	 * 获取子类列表.
	 */
	function get_district_child_list()
	{
		$html = "";
		$pid = (int)$this->input->post('pid');
		$checked = $this->input->post('checked');
		$list = $this->district_model->getChildListByPid($pid);
		if (empty($list)) {
			echo $html;
			exitt;
		}
		$ischecked = $checked=="true" ? "checked" : "";
		foreach ($list as $key => $val) {
			$html .= '<tr class="tr_'.$val['parentid'].'">
						<td>
							<input pid="'.$val['parentid'].'" type="checkbox" name="district_id[]" value="'.$val['id'].'" class="child_'.$val['parentid'].' child" '.$ischecked.'>
							<input type="hidden" name="save_id[]" value="'.$val['id'].'">
						</td>
						<td>
							<div class="am-g">
								<div class="am-u-sm-3">&nbsp;</div>
								<div class="am-u-sm-4 am-u-end">
									<input type="text" name="category_name[]" value="'.$val['category_name'].'" class="">
								</div>
							</div>
						</td>
						<td>
							'.$val['id'].'
						</td>
						<td>
						<div class="am-g">
										<div class="am-u-sm-4 am-u-end">
										<input type="text" value="'.$val['category_order'].'" name="category_order[]"></td>
										</div>
									</div>
						</td>
						<td>
							<div class="am-btn-toolbar">
								<div class="am-btn-group am-btn-group-xs">
									<button class="am-btn am-btn-default am-btn-xs am-text-secondary"><span class="am-icon-pencil-square-o"></span> 编辑</button>
									<button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-trash-o"></span> 删除</button>
								</div>
							</div>
						</td>
					  </tr>';
		}
		echo $html;
	}
}