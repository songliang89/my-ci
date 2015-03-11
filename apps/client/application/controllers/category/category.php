<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by linzl
 * User: linzl<linzhenlong@smzdm.com>
 * Date: 15/3/10
 * Time: 下午5:27
 */
class Category extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('category/district_model');
	}

	/**
	 *  地区列表页
	 */
	function district()
	{
		$url = current_url();
		$postData = $this->input->post();
		if (!empty($postData)) {
			if (isset($postData['save_id']) && is_array($postData['save_id']) && count($postData['save_id']) > 0) {
				$save_cate = array();
				foreach ($postData['save_id'] as $key => $id) {
					$save_cate = array(
						'id' => $id,
						'category_name' => $postData["category_name"][$key],
						'category_order' => $postData["category_order"][$key]
					);
					$this->district_model->updateDistrict($save_cate);
				}
			}
			redirect($url);
		}
		$data = $this->district_model->getTopCategoryList();
		$view_data = array(
			'data' => $data
		);
		$this->load->view('category/district',$view_data);
	}

	/**
	 *  地区编辑页
	 */
	function edit()
	{

	}
}