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

	function get_district_child_list()
	{
		$html = "";
		$pid = (int)$this->input->post('pid');
		$list = $this->district_model->getChildListByPid($pid);
		if (empty($list)) {
			echo $html;
			exitt;
		}

		foreach ($list as $key => $val) {
			$html .= '<tr>
						<td>
							<input type="checkbox" name="district_id[]" value="'.$val['id'].'">
						</td>
						<td>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;">'.$val['category_name'].'</a>
						</td>
						<td>
							'.$val['category_order'].'
						</td>
						<td>
									<div class="am-btn-toolbar">
										<div class="am-btn-group am-btn-group-xs">
											<button class="am-btn am-btn-default am-btn-xs am-text-secondary"><span class="am-icon-pencil-square-o"></span> 编辑</button>
											<button class="am-btn am-btn-default am-btn-xs am-hide-sm-only"><span class="am-icon-copy"></span> 复制</button>
											<button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-trash-o"></span> 删除</button>
										</div>
									</div>
								</td>
					  </tr>';
		}
		echo $html;
	}
}